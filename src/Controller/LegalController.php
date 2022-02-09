<?php

namespace Application\Controller;

use Laminas\View\Model\ViewModel;

class LegalController extends ApplicationModuleController
{

    public function privacyPolicyAction(): ViewModel
    {
        return new ViewModel([]);
    }

    public function termsOfServiceAction(): ViewModel
    {
        return new ViewModel([]);
    }

    public function dataDeletionAction(): ViewModel
    {
        return new ViewModel([]);
    }
}