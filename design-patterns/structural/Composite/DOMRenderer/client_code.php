<?php
require_once('Form.php');
require_once('Input.php');
require_once('Fieldset.php');
require_once('FormElement.php');

/**
 * Client code interface for building a tree structure
 * @return FormElement
 */
function getProductForm(){
    $form = new Form('name', 'Product Title: Add Product', '/product_url/add');
    $form->add(new Input('input_name', 'Input Title', 'text'));
    $form->add(new Input('description', 'Description', 'textarea'));

    $picture = new Fieldset('photo', 'Product Photo');
    $picture->add(new Input('caption', 'Caption', 'text'));
    $picture->add(new Input('image', 'Image', 'file'));
    $picture->add(new Input('description', 'Description', 'textarea'));

    $form->add($picture);
    return $form;
}

/**
 * The form structure can be filled with data from various sources. The Client
 * doesn't have to traverse through all form fields to assign data to various
 * fields since the form itself can handle that.
 * @param FormElement $form
 */
function loadProductData(FormElement $form){
    $data = [
        "name" => "MacBook Pro",
        "description" => "Very pretty",
        "photo" => [
            "caption" => "Screen photo",
            "image" => "photo1.jpg",
            "description" => "An image of the screen"
        ]
    ];

    $form->setData($data);
}

/**
 * The client code can work with form elements using the abstract interface.
 * It does not matter if a client uses a simple component
 * or a composite tree
 * @param FormElement $form
 */
function renderProduct(FormElement $form){
    echo $form->render();
}

$form = getProductForm();
loadProductData($form);
renderProduct($form);