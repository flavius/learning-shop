<?php

namespace App\Tests;

use App\Tests\AcceptanceTester;

class EpsCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function happy_path(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->submitForm('form', []);
        $I->submitForm('#frmlogin', []);
        $I->submitForm('form[name="auftrag"]', [], 'sbtnSign');
        $I->submitForm('form[name="uebersicht"]', [], 'sbtnSignSingle');
        $I->submitForm('form[action="/appl/ebp/umappe/tanSave.html.dispatch?jsStat=disabled"]', [], 'sbtnOk');
        $I->submitForm('div.inputform > form', [], 'back2Shop');
        $I->waitForElement('#transaction_details', 30);
    }
}
