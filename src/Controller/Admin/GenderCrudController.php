<?php

namespace App\Controller\Admin;

use App\Entity\Gender;
use Symfony\Component\HttpFoundation\Request;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GenderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Gender::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Admin | Genres')
            ->setPageTitle(Crud::PAGE_NEW, 'Admin | Ajout d\'un Genre')
            ->setPageTitle(Crud::PAGE_EDIT, 'Admin | Modification d\'un Genre ');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Genre'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $deleteAction = Action::new('Delete', '')
        ->setIcon('fas fa-trash')
        ->linkToCrudAction('deleteAction');

        return $actions
            ->add(Crud::PAGE_INDEX, $deleteAction)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_DETAIL, Action::DELETE)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-plus-circle')->setLabel('Ajouter une Genre');
            })
        ;
    }

    public function deleteAction(AdminContext $context, Request $request)
    {
        $id = $context->getRequest()->query->get('entityId');
        $entity = $this->getDoctrine()->getRepository(Gender::class)->find($id);

        $this->deleteEntity($this->get('doctrine')->getManagerForClass($context->getEntity()->getFqcn()), $entity);
        $this->addFlash('success', 'Cet élément a bien été supprimé');
        // ici modifier la redirection selon ou l'admin doit être redirigé après l'action delete
        return $this->redirect($request->server->get('HTTP_REFERER'));
    }
}
