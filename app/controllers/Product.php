<?php
class Product extends Controller
{
    public $data = [];

    public function index()
    {
        echo 'Danh sách sản phẩm';
    }

    public function list_product()
    {
        $product = $this->model('ProductModel');
        $dataProduct = $product->getProductList();

        $title = 'Danh sách sản phẩm';

        $this->data['product_list'] = $dataProduct;
        $this->data['title_page'] = $title;

        $this->render('products/list', $this->data);
    }

    public function detail()
    {
        $this->data['content'] = 'products/detail';
        $this->render('layouts/client_layout', $this->data);
    }
}
