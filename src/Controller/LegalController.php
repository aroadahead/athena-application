<?php

namespace Application\Controller;

use Laminas\View\Model\ViewModel;

class LegalController extends ApplicationController
{
    public function indexAction()
    {
        return new ViewModel([]);
    }

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