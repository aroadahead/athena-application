<?php

declare(strict_types=1);

namespace Application\Controller;

use AthenaBridge\Laminas\View\Model\ViewModel;

class LegalController extends ApplicationModuleController
{

    public function privacyPolicyAction(): ViewModel
    {
        return $this->newViewModel();
    }

    public function termsOfServiceAction(): ViewModel
    {
        return $this->newViewModel();
    }

    public function dataDeletionAction(): ViewModel
    {
        return $this->newViewModel();
    }
}