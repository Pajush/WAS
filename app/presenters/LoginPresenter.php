<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

class LoginPresenter extends BasePresenter
{

    public function renderDefault() {

    }

    public function createComponentLoginForm() {
        $form = new Form();

        $form->addText('username', 'Uživatelské jméno')
            ->setRequired()
            ->setAttribute('class', 'form-control')
            ->setAttribute('placeholder', 'Napište své jméno');

        $form->addPassword('password', 'Heslo')
            ->setRequired()
            ->setAttribute('class', 'form-control')
            ->setAttribute('placeholder', 'Napište své heslo');

        $form->addSubmit('login', 'Přihlásit se')
            ->setAttribute('class', 'btn btn-lg btn-block btn-success btn-was');

        $form->onSuccess[] = [$this, 'loginFormSucceeded'];
        
        return $form;
    }

    public function loginFormSucceeded(Form $form) {
        $values = $form->getValues();
        try {
            $this->getUser()->login($values->username, $values->password);
            $this->user->setExpiration(0, TRUE);
            $this->flashMessage('Byl jste úspěšně přihlášen.', 'success');
            $this->redirect('Dashboard:default');

        } catch (Nette\Security\AuthenticationException $e) {
            $this->flashMessage($e->getMessage(), 'danger');
        }
    }
}
