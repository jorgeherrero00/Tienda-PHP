<?php 
namespace lib;
class Pages{
    public function render(string $pageName, array $params = null):void{
        if ($params!=null) {
            foreach($params as $name => $value) {
                $$name = $value;
        }
    }
    
    require_once "../src/Views/Layout/header.php";
    require_once "../src/Views/$pageName.php";
    require_once "../src/Views/layout/footer.php";
}
}
?>