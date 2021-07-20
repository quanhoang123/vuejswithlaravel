<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\ProductType;
use PHPUnit\Framework\TestCase;

class TestRelationShip extends TestCase
{
    protected $product;

    // Hàm set up môi tường chạy
    protected function setUp(): void
    {
        parent::setUp();
        $this->product = new Product();
    }

    //  hàm Unset thực hiện sau khi test xong
    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->product);
    }

    public function test_table_name()
    {
        $this->assertEquals('products', $this->product->getTable());
    }


    // Hàm kiểm tra các trường trong class product
    public function test_fillable()
    {
        $this->assertEquals([
            'name', 
            'id_type', 
            'description', 
            'unit_price', 
            'promotion_price', 
            'image', 
            'unit',
            'new'],
             $this->product->getFillable());
    }

    
    protected function test_belongsTo_relation($related, $foreignKey, $ownerKey, $model, $relationName)
    {
        // model là biến dùng truy vấn tới model product
        // $relationName là tên function mình sẽ truyền vào funsction quan hệ ở class product
        $relation = $model->$relationName();
        $this->assertInstanceOf(BelongsTo::class, $relation);
        // Kiểm tra xem function biến product có gọi tới model product_type không
        $this->assertInstanceOf($related, $relation->getRelated()); 
        
        $this->assertEquals($ownerKey, $relation->getOwnerKeyName()); // set id của lớp trong function product có = id ở lớp product_type không?
        
        $this->assertEquals($foreignKey, $relation->getForeignKeyName()); // set id_product_type của lớp trong function product có = id ở lớp product_type không?
    }

    public function test_product_type_relation()
    {
        $this->test_belongsTo_relation(ProductType::class,'id_type','id',$this->product,'cate');
    }
}
