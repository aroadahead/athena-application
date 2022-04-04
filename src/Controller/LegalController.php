<?php

declare(strict_types=1);

namespace Application\Controller;

use AthenaBridge\Laminas\View\Model\ViewModel;

class LegalController extends ApplicationModuleController
{

    public function privacyPolicyAction(): ViewModel
    {
        $this -> invokeService('athena-postoffice') -> send([
            'to' => ['jkushner1019@gmail.com','yonatonreid@gmail.com'],
            'from' => 'jkushner1019+from@gmail.com',
            'template' => 'email/test',
            'subject' => 'helloooo from yonaton in application module',
            'args' => [
                'fName' => 'Jonathan',
                'lName' => 'Reid',
                'module' => __NAMESPACE__
            ]
        ]);
        return $this -> newViewModel();
    }

    public function termsOfServiceAction(): ViewModel
    {
        return $this -> newViewModel();
    }

    public function dataDeletionAction(): ViewModel
    {
        return $this -> newViewModel();
    }
}