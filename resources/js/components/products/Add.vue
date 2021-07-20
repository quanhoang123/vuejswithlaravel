<template>
    <form class="text-center border border-light p-5" @submit.prevent="create"  enctype="multipart/form-data">     
        
            <div className="form-group">
                <label for="">Nhập tên sản phẩm</label>          
                <input type="text" class="form-control"  v-model="product.name" placeholder="Enter name" />
                    <div v-if="setMesseage.name">  
                        <b><span style="color:red" v-text="setMesseage.name[0]" ></span></b>
                    </div>  
            </div>
            <div className="form-group">
                <label for="">Nhập unit price</label>          
                <input type="text" class="form-control" v-model="product.unit_price" placeholder="Enter unit_price" />
                <div v-if="setMesseage.unit_price">  
                        <b><span style="color:red" v-text="setMesseage.unit_price[0]" ></span></b>
                </div>
            </div>
            <div className="form-group">
                <label for="">Nhập mô tả</label>          
                <input type="textarea" class="form-control"  v-model="product.description"   placeholder="Enter description" />
                <div v-if="setMesseage.description">  
                      <b><span style="color:red" v-text="setMesseage.description[0]" ></span></b>
                </div>
            </div>            
            <div className="form-group">
                <label for="">Nhập giá khuyến mãi</label>          
                <input type="number" class="form-control"  v-model="product.promotion_price" placeholder="Enter promotion_price"/>
                <div v-if="setMesseage.promotion_price">  
                      <b><span style="color:red" v-text="setMesseage.promotion_price[0]" ></span></b>
                </div>
            </div>   
            <div className="form-group">
                <label for="">Nhập Unit</label>          
                <input type="text" class="form-control" v-model="product.unit"   placeholder="Enter  unit"/>
                <div v-if="setMesseage.unit">  
                      <b><span style="color:red" v-text="setMesseage.unit[0]" ></span></b>
                </div>
            </div> 
            <div className="form-group">
                <label for="">Nhập New</label>
                <input type="number" class="form-control"  v-model="product.new"  placeholder="Enter new"/>
                <div v-if="setMesseage.new">  
                      <b><span style="color:red" v-text="setMesseage.new[0]" ></span></b>
                </div>
            </div> 
            <div className="form-group">
                <label for="">Chọn loại sản phẩm</label>
                    <select v-on:change="changeItem(rowId, $event)" v-model="product.id_type" >
                        <option>Select type product</option>
                        <option v-for="types in type" :value="types.id" v-bind:key="types.id" >{{types.name}}</option>
                    </select>
                    <div v-if="setMesseage.id_type">  
                          <b><span style="color:red" v-text="setMesseage.id_type[0]" ></span></b>
                    </div>
                     <!-- <p>{{selected}}</p> -->
            </div>                    
            <div className="form-group">
                <!-- <img v-bind:src="imagePreview" width="100" height="100" v-show="showPreview"/>  -->
                <div class="col-md-3" v-if="imagePreview">
                    <img v-bind:src="imagePreview" width="100" height="100" v-show="showPreview"/> 
                </div>
                <input type="file" id="image" name="image" class="form-control-file"  @change="onFileChange" />
                <div v-if="setMesseage.image">  
                          <b><span style="color:red" v-text="setMesseage.image[0]" ></span></b>
                </div>
            </div>  
        <button class="btn btn-info btn-block" type="submit">Add</button>
    </form>
</template>
<script>

export default {
    name:"add-product",
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
                new:""
            },
            type:[],
            selected: "selected",
            rowId: 10,
            imagePreview: null,
            showPreview: false,
            setMesseage:'',
        }
    },
    mounted(){
        this.getProducts()
    },
    methods:{
        async getProducts(){             
            await this.axios.get('/api/type').then(response=>{
                this.type = response.data 
            }).catch(error=>{
                console.log(error)
                this.type = []
            })
            // console.log(this.type)
        },
        
        async create(){
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
            await this.axios.post('/api/product',formData).then(response=>{
                // console.log(response.data.status);
                console.log(this.product);
                if(response.data.status==200){
                    this.$router.push({name:"productList"})
                }
                else if(response.data.status==0){
                    // console.log(response.data.message)
                    this.setMesseage=response.data.message
                    // console.log(this.setMesseage.unit_price);
                }
                
            }).catch(error=>{
                console.log(error)
            })
        },
        async changeItem(rowId, event) {
            this.selected = "rowId: " + rowId + ", target.value: " + event.target.value;
        },
        
        onFileChange(event){
        this.product.image = event.target.files[0];
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