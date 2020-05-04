<?php 
/* 
(POST) pizzas: (Solo para encargado ). Recibe tipo (molde o piedra), precio, stock, sabor (jamón, napo,
muzza) y foto y lo guarda en el archivo pizzas.xxx, a la imagen la guarda en la carpeta imágenes . Validar
los tipos y sabores. La combinación tipo - sabor debe ser única.

(GET) pizzas: (Encargado y cliente) Muestra la lista de pizzas, si es encargado muestra el stock, si es user
no muestra stock.

(POST) Ventas: (Solo clientes) Recibe tipo y sabor y si existe esa combinación y hay stock devuelve el
monto total de la operación. Si se realiza la venta restar el stock a la pizza y guardar la venta archivo
ventas.xxx el email, tipo, sabor, monto y fecha.

(GET) ventas: Si es encargado muestra el monto total y la cantidad de las ventas, si es cliente solo las
compras de dicho usuario.

7. Generar una marca de agua al subir la foto en el punto 3.
 */
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
    //tipo (molde o piedra), precio, stock, sabor (jamón, napo, muzza) y foto
    public function setProduct($tipo, $precio, $stock, $sabor, $foto){
        try {
            $list = FileData::file2Obj('pizzas.json');
            if($list == null){$list = [];}
        } catch (\Throwable $th) {
            return 500;
        }
        if(self::findProductByTipoSabor($tipo,$sabor,$list) != null){
            return 400;
        }
        $product = new StdClass();
        // $product->id = self::getId($list);
        $product->tipo = $tipo;
        $product->precio = $precio;
        $product->stock = $stock;
        $product->sabor  = $sabor;
        $product->foto = $foto;
        array_push($list,$product);
        try {
            FileData::obj2File($list,'pizzas.json');
            return $product;
        } catch (\Throwable $th) {
            return 500;
        }
    }
    
    private function findProductByTipoSabor($tipo,$sabor,$list){
        if($list == null){
            return null;
        }
        foreach($list as $prod){
            if($tipo == $prod->tipo && $sabor == $prod->sabor){
                return $prod;
            }
        }
        return null;
    }
    
    public function setSale($tipo, $sabor, $email){
        try {
            $listProd = FileData::file2Obj('pizzas.json');
            if($listProd == null){$listProd = [];}
        } catch (\Throwable $th) {
            return 500;
        }
        $product = self::findProductByTipoSabor($tipo,$sabor,$listProd);
        if($product == null){
            return 404;
        }
        if($product->stock <= 0){
            return 400;
        }
        $product->stock = $product->stock - 1;
        try {
            FileData::obj2File($listProd,'pizzas.json');
        } catch (\Throwable $th) {
            return 500;
        }

        /// registrar venta email, tipo, sabor, monto y fecha.
        $sale = new StdClass();
        $sale->email = $email;
        $sale->tipo = $product->tipo;
        $sale->sabor = $product->sabor;
        $sale->precio = $product->precio;
        
        try {
            $listSale = FileData::file2Obj('ventas.json');
            if($listSale == null){$listSale = [];}
        } catch (\Throwable $th) {
            echo $th;
            return 501;
        }
        array_push($listSale,$sale);
        $res = new StdClass();
        $res->total = $product->precio;
        try {
            FileData::obj2File($listSale,'ventas.json');
            return $res;
        } catch (\Throwable $th) {
            return 502;
        }
    }
    public function getProducts($payload){
        try {
            $list = (array)FileData::file2Obj('pizzas.json');
            if($list == null){$list = [];}
            // return $list;
        } catch (\Throwable $th) {
            return 500;
        }
        if($payload->typ == "encargado"){
            return $list;
        } else if($payload->typ == "cliente"){
            $newList = [];
            foreach($list as $prod){
                $product = new StdClass();
                $product->tipo = $prod->tipo;
                $product->precio = $prod->precio;
                // $product->stock = $prod->stock;
                $product->sabor  = $prod->sabor;
                $product->foto = $prod->foto->name;
                array_push($newList,$product);
            }
            return $newList;
        } else {
            return 400;
        }
    }
    public function getSales($payload){
        try {
            $list = (array)FileData::file2Obj('ventas.json');
            if($list == null){$list = [];}
        } catch (\Throwable $th) {
            return 500;
        }
        if($payload->typ == "encargado"){
            return $list;
        } else if($payload->typ == "cliente"){
            return self::findSaleByUser($payload->sub, $list);
        } else {
            return 400;
        }
    }
    
    private function findSaleByUser($userEmail,$list){
        if($list == null || Count($list) <1){
            return null;
        }
        $newList = [];
        foreach($list as $sale){
            if($userEmail == $sale->email){
                array_push($newList,$sale);
            }
        }
        return $newList;
    }

}
