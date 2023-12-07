<?php

namespace App\Imports;

use App\Models\Api\V1\Membership\Family;
use App\Models\Api\V1\Membership\Member;
use App\Models\Api\V1\Membership\Group;
use App\Models\Api\V1\Sales\Broker;
use App\Models\Api\V1\Lookups\SubscriptionPeriod;
use App\Models\Api\V1\Lookups\GroupType;
use App\Models\Api\V1\Lookups\SchemeOption;
use App\Models\Api\V1\Lookups\SchemeType;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

use \PhpOffice\PhpSpreadsheet\Shared\Date;

class MembersImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts, WithValidation
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            $member = Member::where('member_number', '=', $row['member_number'])->first();

            if(!$member){
                $member = new Member;
            }

            $member_email = Member::where('email', '=', $row['email'])->first();
            
            $email = null;
            if(!$member_email){
                $email = $row['email'];
            }

            $member->family_id = $this->getFamilyId($row, $row['unique_linker'], $row['last_name']);
            $member->scheme_option_id = $this->getSchemeOptionId($row['scheme_name']);
            // $member->scheme_type_id = $this->getSchemeTypeId($row[16]);
            $member->dependent_code = $row['relationship'] == 'Principal Member' ? "00" : "01";
            $member->member_number = $row['member_number'];
            $member->title = $row['title'];
            $member->first_name = $row['first_name'];
            $member->last_name = $row['last_name'];
            // $member->other_names = $row[5];
            $member->dob = $row['dob'] ? Date::excelToDateTimeObject((int)$row['dob'])->format('Y-m-d') : null;
            $member->gender = $row['gender'] ? $row['gender'] : 'NA';
            // $member->marital_status = $row[7];
            $member->language = $row['language'];
            $member->nrc_or_passport_no = $row['nrc_or_passport_no'];
            // $member->occupation = $row[9];
            $member->relationship = $row['relationship'];
            $member->email = $email;
            $member->work_number = $row['employee_number'] ? $row['employee_number'] : null;
            $member->mobile_number = $row['mobile_number'];
            $member->is_chronic = $row['chronic'] == 'yes' ? true : false;
            $member->sage_account = $row['sage_account'];
            $member->join_date = $row['join_date'] ? Date::excelToDateTimeObject((int)$row['join_date'])->format('Y-m-d') : null;
            // $member->is_principal = $row[1] == "00" ? true : false;
            // $member->has_sports_loading = $row[32];
            // $member->sports_loading_start_date = $row['benefit_start_date'] ? Date::excelToDateTimeObject($row[33])->format('Y-m-d') : "";
            // $member->sports_loading_end_date = $row['benefit_start_date'] ? Date::excelToDateTimeObject($row[34])->format('Y-m-d') : "";
            // $member->sporting_activity = $row[35];
            $member->save();
        }
    }

    /**
     * Getting the family id by first adding the family group if 
     * it doesnt exist or getting the existing id if found.
     */
    private function getFamilyId($row, $unique_linker, $last_name){
        $family = Family::where('unique_linker', '=', $unique_linker)->first();

        if (!$family){
            $family = new Family;
        }

        $b_end_date = $row['benefit_end_date'] ? Date::excelToDateTimeObject((int)$row['benefit_end_date'])->format('Y-m-d') : null;

        $family->group_id = $this->getGroupId($row['company_code'], $row['company_name']);
        // $family->subscription_period_id = $this->getSubscriptionPeriodId($row[20]);
        $family->subscription_period_id = 3;
        // $family->broker_id = $this->getBrokerId($row[17]);
        $family->group_type_id = 1;
        $family->family_code = $this->generateFamilyCode($last_name);
        $family->unique_linker = $unique_linker;
        $family->nearest_city = $row['nearest_city'];
        $family->province = $row['province'];
        $family->physical_address = $row['physical_address'];
        $family->postal_address = $row['postal_address'];
        $family->postal_code = $row['postal_code'];
        $family->has_funeral_cash_benefit = isset($row['has_funeral_cash_benefit']) && $row['has_funeral_cash_benefit'] == 'yes' ? 1 : 0;
        $family->resign_code = $row['resign_code'];
        // $family->nationality = $row[21];
        $family->benefit_start_date = $row['benefit_start_date'] ? Date::excelToDateTimeObject((int)$row['benefit_start_date'])->format('Y-m-d') : null;
        $family->benefit_end_date = $row['benefit_end_date'] ? Date::excelToDateTimeObject((int)$row['benefit_end_date'])->format('Y-m-d') : null;
        $family->application_date = $row['application_date'] ? Date::excelToDateTimeObject((int)$row['application_date'])->format('Y-m-d') : date('Y-d-m');
        // $family->suspension_date = $row['benefit_end_date'] ? Date::excelToDateTimeObject($row[37])->format('Y-m-d') : null;
        // $family->suspension_lifted_date = Date::excelToDateTimeObject($row[38])->format('Y-m-d');
        // $family->next_renewal_date = Date::excelToDateTimeObject($row[28])->format('Y-m-d');
        $family->in_holding_tank = 0;
        $family->status = ($row['benefit_end_date'] && (int)$row['benefit_end_date'] > 0) ? 'resigned' : 'active';
        $family->save();

        return $family->id;
    }

    /**
     * Getting the employer group id
     */
    private function getGroupId($code, $name){
        $group = Group::where('code', '=', $code)->first();

        if($group){
            return $group->id;
        }else{
            $group = new Group;
            $group->group_name = $name;
            $group->code = $code;
            $group->group_type = strpos($name, "Individual Members") !== false ? 'individual' : 'corporate';
            $group->status = 'active';
            $group->save();
            return $group->id;
        }

        return null;
    }

    /**
     * Getting the subscription period id
     */
    private function getSubscriptionPeriodId($period){
        $subscription_period = SubscriptionPeriod::where('name', '=', $period)->first();

        if($subscription_period){
            $subscription_period->id;
        }

        return null;
    }

    /**
     * Getting the broker id
     */
    private function getBrokerId($code){
        $broker = Broker::where('code', '=', $code)->first();

        if($broker){
            $broker->broker_id;
        }

        return null;
    }

    /**
     * Getting the group type id
     */
    private function getGroupTypeId($name){
        $group_type = GroupType::where('name', '=', $name)->first();

        if($group_type){
            return $group_type->id;
        }

        return null;
    }

    /**
     * Generating the family code
     */
    private function generateFamilyCode($last_name){
        // Generating the family Code
        $last_family_number = null;
        $nextId = null;

        $last_family_number = Family::all()->last();
        $nextId = ($last_family_number === null ? 0 : $last_family_number->id) + 1;

        $suffix = str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $code_prefix = mb_strtoupper(mb_substr($last_name,0,3));

        $family_code = $code_prefix . $suffix;

        return $family_code;
    }

    /**
     * Getting the scheme option id
     */
    private function getSchemeOptionId($name){
        $scheme_option = SchemeOption::where('name', '=', $name)->first();

        if ($scheme_option){
            return $scheme_option->id;
        }else{
            $scheme = new SchemeOption;
            $scheme->name = $name;
            $scheme->tier_level = -1;
            $scheme->member_types = 'unspecified';
            $scheme->save();
            
            return $scheme->id;
        }

        return null;
    }

    /**
     * Getting the scheme type id
     */
    private function getSchemeTypeId($description){
        $scheme_type = SchemeType::where('description', '=', $description)->first();

        if ($scheme_type){
            return $scheme_type->id;
        }

        return null;
    }

    public function batchSize(): int
    {
        return 2000;
    }

    public function chunkSize(): int
    {
        return 2000;
    }

    public function rules(): array
    {
        return [
            '*.member_number' => ['required', 'integer'],
            '*.first_name' => ['required'],
            '*.last_name' => ['required'],
            '*.unique_linker' => ['nullable'],
            '*.relationship' => ['nullable'],
            '*.dob' => ['nullable'],
            '*.language' => ['nullable', 'sometimes'],
            '*.postal_address' => ['nullable', 'sometimes'],
            '*.postal_code' => ['nullable', 'sometimes'],
            '*.physical_address' => ['nullable', 'sometimes'],
            '*.nearest_city' => ['nullable', 'sometimes'],
            '*.province' => ['nullable', 'sometimes'],
            '*.mobile_number' => ['nullable', 'sometimes'],
            '*.subcompany_code' => ['nullable', 'sometimes'],
            '*.subcompany_name' => ['nullable', 'sometimes'],
            '*.company_code' => ['nullable', 'sometimes'],
            '*.company_name' => ['nullable', 'sometimes'],
            '*.company_effective_date' => ['nullable'],
            '*.application_date' => ['nullable', 'sometimes'],
            '*.join_date' => ['nullable', 'sometimes'],
            '*.benefit_start_date' => ['nullable', 'sometimes'],
            '*.benefit_end_date' => ['nullable', 'sometimes'],
            '*.payment_expiry_date' => ['nullable', 'sometimes'],
            '*.resign_code' => ['nullable', 'sometimes'],
            '*.scheme_name' => ['nullable', 'sometimes'],
            '*.employee_number' => ['nullable', 'sometimes'],
            '*.subscription_code' => ['nullable', 'sometimes'],
            '*.premium' => ['nullable', 'sometimes'],
            '*.comp_discount' => ['nullable', 'sometimes'],
            '*.discount_or_increase' => ['nullable', 'sometimes'],
            '*.mem_discount' => ['nullable', 'sometimes'],
            '*.gender' => ['nullable'],
            '*.passport_or_nrc_no' => ['nullable', 'sometimes'],
            '*.broker_code' => ['nullable', 'sometimes'],
            '*.broker_name' => ['nullable', 'sometimes'],
            '*.email' => ['nullable', 'sometimes'],
            '*.suburb' => ['nullable', 'sometimes'],
            '*.chronic' => ['nullable', 'sometimes'],
            '*.sage_account' => ['nullable', 'sometimes']
        ];
    }
}