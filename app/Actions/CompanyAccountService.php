<?php

namespace App\Actions;

use App\Models\{CompanyAccount,ImportStatus};
trait CompanyAccountService
{
    public function exists_company_account($company_id)
    {
        return CompanyAccount::where('company_id',(int)$company_id)->exists();
    }

    public function most_recent_company_value($company_id){
      $company_value=CompanyAccount::where('company_id',(int)$company_id)->orderby('id','desc')->first('value');
      return (int)$company_value->value;     
    }
}
