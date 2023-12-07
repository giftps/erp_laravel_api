<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Api\V1\Lookups\BenefitOption;

use App\Models\Api\V1\Lookups\SchemeBenefitAmount;

use App\Models\Api\V1\Membership\Family;

use App\Models\Api\V1\Membership\Member;

use App\Notifications\FamilyStatusChange;

use App\Notifications\AccountSuspension;

use Carbon\Carbon;

class ChangeMemberStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:family_status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to change the status of the family.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->activateFamily();
        $this->suspendMembers();
        return 0;
    }

    private function activateFamily(){
        $date = date('Y-m-d');

        Family::where('benefit_start_date', 'LIKE', $date)->where('status', '!=', 'active')->update(['status' => 'active', 'in_holding_tank' => false]);

        $family_ids = Family::where('benefit_start_date', '<=', $date)->where('status', '=', 'active')->pluck('id');

        $members = Member::whereIn('family_id', $family_ids)->where('dependent_code', '=', '00')->get();

        $all_families_members = Member::whereIn('family_id', $family_ids)->where('is_resigned', '=', 0)->get();

        
        foreach($all_families_members as $member){
            addMemberBenefits($member->member_id);
        }
    }

    private function suspendMembers(){
        $families = Family::where('next_renewal_date', '=', date('Y-m-d'))->get();

        foreach($families as $family){
            $fam = Family::find($family->id);
            $fam->status = 'suspended';
            $fam->save();

            $member = Member::where('family_id', '=', $family->id)->where('dependent_code', '=', '00')->first();

            $member->notify(new AccountSuspension($member));
        }
    }
}
