<?php

namespace App\Presenters;

use App\Model\NoDataFound;
use Nette;
use App\Model\TagModel;

class TagsPresenter extends BasePresenter
{

    /** @var TagModel - model pro management rc*/
    private $tagModel;

    public function injectDependencies(TagModel $tagModel) {
        $this->tagModel = $tagModel;
    }

    public function renderDefault() {
        $this->template->tags = $this->tagModel->listTags();
        if (!isset($this->template->edit))
            $this->template->edit = NULL;
    }

    public function createComponentAddTag() {
        $form = new Nette\Application\UI\Form();

        $form->addText('name', 'Jméno')
            ->setAttribute('placeholder', 'Napište jméno tagu')
            ->setAttribute('class', 'form-control');

        $form->addSubmit('save', 'Uložit')
            ->setAttribute('class', 'btn btn-block btn-success');


        $form->onSuccess[] = [$this, 'handleAddTag'];

        return $form;
    }

    public function createComponentEditTag() {
        $form = new Nette\Application\UI\Form();

        $form->addText('name', 'Jméno')
            ->setAttribute('placeholder', 'Napište jméno tagu')
            ->setAttribute('class', 'form-control');

        $form->addSubmit('save', 'Uložit')
            ->setAttribute('class', 'btn btn-block btn-success');

        $form->addHidden('id');

        $form->onSuccess[] = [$this, 'handleEditTag'];

        return $form;
    }

    public function handleAddTag( Nette\Application\UI\Form $form) {
        $values = $form->getValues();

        // kontrola duplicity jména
        $exist = $this->tagModel->getTagByName($values->name);
        if ($exist) {
            $this->flashMessage('Tento tag už existuje!', 'danger');
            $this->redrawControl('flashes');
        } else {
            $id = $this->tagModel->insertTag($values);
            $this->template->tags = $this->tagModel->listTags();
            $this->redrawControl('tags');
        }
        $this->flashMessage('Tag byl úspěšně přidán', 'success');
        $this->redrawControl('flashes');

    }

    public function handleEditTag( Nette\Application\UI\Form $form) {
        $values = $form->getValues();

        // kontrola duplicity jména
        $exist = $this->tagModel->getTagByName($values->name);
        if ($exist) {
            $this->flashMessage('Tento tag už existuje!', 'danger');
            $this->redrawControl('flashes');
        } else {
            $id = $this->tagModel->updateTag($values->id, $values);
            $this->template->tags = $this->tagModel->listTags();
            $this->redrawControl('tags');
        }
        $this->flashMessage('Tag byl úspěšně změněn', 'success');
        $this->redrawControl('flashes');

    }

    public function handleDeleteTag($id) {
        try {
            $tag = $this->tagModel->getTag($id);
            $this->tagModel->deleteTag($id);
            $this->flashMessage('Tag byl úspěšně smazán', 'success');
            $this->redrawControl('flashes');

        } catch  ( NoDataFound $e) {
            $this->flashMessage('Nelze smazat neexistující prvek!', 'danger');
            $this->redrawControl('flashes');
        }
    }

    public function handleSetEdit($tagId) {
        
        if ($tagId != 'new') {
            try {
                $tag = $this->tagModel->getTag($tagId);

                $this->template->edit = $tag;

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
