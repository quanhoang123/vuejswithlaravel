<template>
    <form class="text-center border border-light p-5"  @submit.prevent="update"  enctype="multipart/form-data">     
        <div className="form-group">
            <label for="">Nhập tên sản phẩm</label>          
                <input type="text" class="form-control"  v-model="product.name" placeholder="Enter name" />
            </div>
            <div className="form-group">
                <label for="">Nhập unit price</label>          
                <input type="text" class="form-control" v-model="product.unit_price" placeholder="Enter unit_price" />
            </div>
            <div className="form-group">
                <label for="">Nhập mô tả</label>          
                <input type="textarea" class="form-control"  v-model="product.description"   placeholder="Enter description" />
            </div>            
            <div className="form-group">
                <label for="">Nhập giá khuyến mãi</label>          
                <input type="number" class="form-control"  v-model="product.promotion_price" placeholder="Enter promotion_price"/>
            </div>   
            <div className="form-group">
                <label for="">Nhập Unit</label>          
                <input type="text" class="form-control" v-model="product.unit"   placeholder="Enter  unit"/>
            </div> 
            <div className="form-group">
                <label for="">Nhập New</label>
                <input type="number" class="form-control"  v-model="product.new"  placeholder="Enter new"/>
            </div> 
            <div className="form-group">
                <label for="">Chọn loại sản phẩm</label>
                    <select v-on:change="changeItem(rowId, $event)" v-model="product.id_type" >
                        <option>select type product</option>
                        <option v-for="types in type" :value="types.id" v-bind:key="types.id" >{{types.name}}</option>
                    </select>
            </div>                    
            <div className="form-group">
                <img :src="getLogo(product.image)" width="100" height="100" id="oldimage" /> 
                <div class="col-md-3" v-if="imagePreview">
                    <img v-bind:src="imagePreview"  width="100" height="100" v-show="showPreview"/> 
                </div>
                <input type="file" id="image" name="image" class="form-control-file"  @change="onFileChange" />
            </div>  
        <button class="btn btn-info btn-block" type="submit">Update</button>
    </form>
</template>
<script>

export default {
    name:"edit-product",
    data(){
        return {
            product:{
                name:"",
                id_type:"",
                image:null,
                description:"",
                unit_price:"",
                promotion_price:"",
                unit:"",
                new:"",
            },
            type:[],
            selected: "selected",
            rowId: 10,
            imagePreview: null,
            showPreview: false,
        }
    },
    mounted(){
        this.getProducts();
        this.showProduct()
    },
    methods:{
        getLogo(Image){
        return 'images/'+Image;
        },
        async getProducts(){             
            await this.axios.get('/api/type').then(response=>{
                this.type = response.data
            }).catch(error=>{
                console.log(error)
                this.type = []
            })
            console.log(this.type)
        },
        async showProduct(){
            await this.axios.get(`/api/product/${this.$route.params.id}`).then(response=>{
                const {name,id_type,image,description,unit_price,promotion_price,unit,new1} = response.data
                this.product.name = name
                this.product.id_type = id_type
                this.product.image = image
                this.product.description = description
                this.product.unit_price = unit_price
                this.product.promotion_price = promotion_price
                this.product.unit = unit
                this.product.new = new1
            }).catch(error=>{
                console.log(error)
            })
        },
        
        async update(){
            let formData = new FormData();
            formData.append("name",this.product.name);
            formData.append("image", this.product.image);
            // alert(formData.getAll('image'));
            formData.append("id_type", this.product.id_type);
            formData.append("description", this.product.description);
            formData.append("unit_price",this.product.unit_price);
            formData.append("promotion_price",this.product.promotion_price);
            formData.append("new",this.product.new);
            formData.append("unit",this.product.unit);
            formData.append('_method',"put");
            await this.axios.post(`/api/product/${this.$route.params.id}`,formData).then(response=>{
               this.$router.push({name:"productList"});
               console.log(response.data);
            }).catch(error=>{
                console.log(error)
            })
        },
        async changeItem(rowId, event) {
            this.selected = "rowId: " + rowId + ", target.value: " + event.target.value;
        },
        
        onFileChange(event){
        this.product.image = event.target.files[0];
        document.getElementById('oldimage').value='hidden';
        let reader  = new FileReader();
            reader.addEventListener("load", function () {
                this.showPreview = true;
                this.imagePreview = reader.result;
            }.bind(this), false);
        if( this.product.image ){
        if ( /\.(jpe?g|png|gif)$/i.test( this.product.image.name ) ) {
            console.log("Oke");
            reader.readAsDataURL( this.product.image );
        }
    }
}
    }
}
</script>