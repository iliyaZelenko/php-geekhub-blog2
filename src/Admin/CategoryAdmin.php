<?php

namespace App\Admin;

use App\Entity\Category;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CategoryAdmin extends AbstractAdmin
{
    public function toString($object)
    {
        return $object instanceof Category
            ? $object->getTitle()
            : 'Category';
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title', TextType::class);
        $formMapper->add('order', IntegerType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title');
        $datagridMapper->add('order');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title');
        $listMapper->addIdentifier('order');
    }
}
