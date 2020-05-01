<?php 
/* 
* (POST) stock: (Solo para admin). Recibe producto (vacuna o medicamento), marca, precio, stock y foto y
  lo guarda en un archivo en formato JSON, a la imagen la guarda en la carpeta imágenes . Generar un
  identificador (id) único para cada producto
* (GET) stock: Muestra la lista de productos.
* (POST) Ventas: (Solo usuarios) Recibe id y cantidad de producto y usuario y si existe esa cantidad de
  producto devuelve el monto total de la operación. Si se realiza la venta restar el stock al producto y
  guardar la venta serializado en el archivo ventas.xxx .

* (GET) ventas: Si es admin muestra listado con todas las ventas, si es usuario solo las ventas de dichousuario
* Generar una marca de agua al subir la foto. */
class Products {
    

    private function getId($list){
        $max=0;
        foreach($list as $user){
            if($max < $user->id){
                $max = $user->id;
            }
        }
        return $max + 1;
    }
    public function setProduct($producto, $marca, $precio, $stock, $foto){
        try {
            $list = FileData::file2Obj('stock.json');
            if($list == null){$list = [];}
        } catch (\Throwable $th) {
            return 500;
        }
        $product = new StdClass();
        $product->id = self::getId($list);
        $product->producto = $producto;
        $product->marca = $marca;
        $product->precio = $precio;
        $product->stock = $stock;
        $product->foto = $foto;
        array_push($list,$product);
        try {
            FileData::obj2File($list,'stock.json');
            return $product;
        } catch (\Throwable $th) {
            return 500;
        }
    }
    
    private function findProductByID($id,$list){
        if($list == null){
            return null;
        }
        foreach($list as $prod){
            if($id == $prod->id){
                return $prod;
            }
        }
        return null;
    }
    
    public function setSale($id, $cantidad){
        try {
            $listProd = FileData::file2Obj('stock.json');
            if($listProd == null){$listProd = [];}
        } catch (\Throwable $th) {
            return 500;
        }
        $product = self::findProductByID($id,$listProd);
        if($product == null){
            return 404;
        }
        if($product->stock < $cantidad){
            return 409;
        }
        $product->stock = $product->stock - $cantidad;
        try {
            FileData::obj2File($listProd,'stock.json');
        } catch (\Throwable $th) {
            return 500;
        }

        /// registrar venta
        $sale = new StdClass();
        $sale->total = $cantidad * $product->precio;
        $sale->cantidad = $cantidad;
        $sale->product_id = $product->id;
        $sale->product_price = $product->precio;
        
        try {
            $listSale = FileData::file2Obj('sales.json');
            if($listSale == null){$listSale = [];}
        } catch (\Throwable $th) {
            return 500;
        }
        array_push($listSale,$sale);
        $res = new StdClass();
        $res->total = $sale->total;
        try {
            FileData::obj2File($listSale,'sales.json');
            return $res;
        } catch (\Throwable $th) {
            return 500;
        }
    }
    public function getProducts(){
        try {
            $list = (array)FileData::file2Obj('stock.json');
            if($list == null){$list = [];}
            return $list;
        } catch (\Throwable $th) {
            return 500;
        }
    }
    public function getSales(){
        try {
            $list = (array)FileData::file2Obj('sales.json');
            if($list == null){$list = [];}
            return $list;
        } catch (\Throwable $th) {
            return 500;
        }
    }

}
?>