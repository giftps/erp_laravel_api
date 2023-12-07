<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Storage;

use PDF;

use Carbon\Carbon;

use App\Models\Api\V1\Membership\Family;
use App\Models\Api\V1\Membership\Member;
use App\Notifications\RenewalQuotation;
use App\Models\Api\V1\Lookups\Year;
use App\Models\Api\V1\Sales\Quotation;
use App\Models\Api\V1\Membership\MemberFolder;
use App\Models\Api\V1\Membership\MemberDocument;
use App\Notifications\MemberQuotation;


class RenewalReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renewal:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command reminds the member to renew their membership.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->checkUpcomingRenewals();
        return 0;
    }

    private function checkUpcomingRenewals(){
        $date = Carbon::now()->addDays(45)->format('Y-m-d');

        $families = Family::where('next_renewal_date', '=', $date)->get();

        if(count($families) > 0){
            foreach($families as $family){
                $member = Member::where('dependent_code', '=', '00')->where('family_id', '=', $family->id)->first();

                $members = Member::where('family_id', '=', $family->id)->get();

                $file = $this->generateQuotation($members, $member);

                $member->notify(new RenewalQuotation($member, $file['attach_file']));
            }
        }
    }

    public function generateQuotation($members, $member){


        $quotation_number = $this->quotationNumber();

        $family_id = $member->family?->id;


        $member_folder_id = MemberFolder::where('name', '=', 'Sales')->first()?->id;

        $data = [
            'members' => $members,
            'member' => $member,
            'year_id' => Year::where('year', '=', date('Y'))->first()?->id,
            'quotation_number' => $quotation_number
        ];

        $pdf = PDF::loadView('documents.renewal-quotation', $data);

        $file_name = time() . 'renewal_quotation.pdf';

        $file = 'public/member-quotations/' . $file_name;
        $path = '/storage/member-quotations/' . $file_name;

        // Saving to starage;
        Storage::put($file, $pdf->output());

        // Saving the quotation
        $member_folder_id = MemberFolder::where('name', '=', 'Sales')->first()?->id;

        $quotation = new Quotation;
        $quotation->family_id = $family_id;
        $quotation->quotation_number = $quotation_number;
        $quotation->path = $path;
        $quotation->member_folder_id = $member_folder_id;
        $quotation->is_first = false;
        $quotation->save();

        // Saving in member documents
        // Saving it in member documents
        $member = Family::find($family_id)->members()->where('dependent_code', '=', '00')->first();

        $member_document = new MemberDocument;
        $member_document->member_folder_id = $member_folder_id;
        $member_document->member_id = $member->member_id;
        $member_document->name = 'Member Quotation - ' . date('Y-m-d H:i:s');
        $member_document->path = $path;
        $member_document->save();

        // Returning the attachment and path
        return collect([
            'path' => $path,
            'attach_file' => Storage::path($file)
        ]);
    }

    private function quotationNumber(){
        // Generating the Membership Number
        $last_id = Quotation::all()->last();
        $nextId = ($last_id === null ? 0 : $last_id->id) + 1;

        $suffix = str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $quotation_number = date('y') . $suffix;

        return $quotation_number;
    }
}
