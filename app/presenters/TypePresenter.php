<?php

namespace App\Presenters;

use App\Model\NoDataFound;
use Nette;
use App\Model\TypeModel;

class TypePresenter extends BasePresenter
{

    /** @var TypeModel - model pro management rc*/
    private $typeModel;

    public function injectDependencies(TypeModel $typeModel) {
        $this->typeModel = $typeModel;
    }

    public function renderDefault() {
        $this->template->type = $this->typeModel->listTypes();
        if (!isset($this->template->edit))
            $this->template->edit = NULL;
    }

    public function createComponentAddType() {
        $form = new Nette\Application\UI\Form();

        $form->addText('name', 'Jméno')
            ->setAttribute('placeholder', 'Napište typ')
            ->setAttribute('class', 'form-control');

        $form->addSubmit('save', 'Uložit')
            ->setAttribute('class', 'btn btn-block btn-success');


        $form->onSuccess[] = [$this, 'handleAddType'];

        return $form;
    }

    public function createComponentEditType() {
        $form = new Nette\Application\UI\Form();

        $form->addText('name', 'Jméno')
            ->setAttribute('placeholder', 'Napište typ')
            ->setAttribute('class', 'form-control');

        $form->addSubmit('save', 'Uložit')
            ->setAttribute('class', 'btn btn-block btn-success');

        $form->addHidden('id');

        $form->onSuccess[] = [$this, 'handleEditType'];

        return $form;
    }

    public function handleAddType( Nette\Application\UI\Form $form) {
        $values = $form->getValues();

        // kontrola duplicity jména
        $exist = $this->typeModel->getTypeByName($values->name);
        if ($exist) {
            $this->flashMessage('Tento typ už existuje!', 'danger');
            $this->redrawControl('flashes');
        } else {
            $id = $this->typeModel->insertType($values);
            $this->template->types = $this->typeModel->listTypes();
            $this->redrawControl('types');
        }
        $this->flashMessage('Typ byl úspěšně přidán', 'success');
        $this->redrawControl('flashes');

    }

    public function handleEditType( Nette\Application\UI\Form $form) {
        $values = $form->getValues();

        // kontrola duplicity jména
        $exist = $this->typeModel->getTypeByName($values->name);
        if ($exist) {
            $this->flashMessage('Tento typ už existuje!', 'danger');
            $this->redrawControl('flashes');
        } else {
            $id = $this->typeModel->updateType($values->id, $values);
            $this->template->types = $this->typeModel->listTypes();
            $this->redrawControl('types');
        }
        $this->flashMessage('Typ byl úspěšně změněn', 'success');
        $this->redrawControl('flashes');

    }

    public function handleDeleteType($id) {
        try {
            $type = $this->typeModel->getType($id);
            $this->typeModel->deleteType($id);
            $this->flashMessage('Typ byl úspěšně smazán', 'success');
            $this->redrawControl('flashes');

        } catch  ( NoDataFound $e) {
            $this->flashMessage('Nelze smazat neexistující prvek!', 'danger');
            $this->redrawControl('flashes');
        }
    }

    public function handleSetEdit($typeId) {
        
        if ($typeId != 'new') {
            try {
                $type = $this->typeModel->getType($typeId);

                $this->template->edit = $type;

            } catch  ( NoDataFound $e) {
                $this->flashMessage('Nelze provést toto nastavení!', 'danger');
                $this->redrawControl('flashes');
            }
        } else {
            $this->template->edit = 'new';
        }

        $this->redrawControl('modalRemove');
        $this->redrawControl('modalEdit');
    }
}
