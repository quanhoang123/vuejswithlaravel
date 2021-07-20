<template>
    <div class="row">
        <div class="col-12 mb-2 text-end">
            <router-link :to='{name:"productAdd"}' class="btn btn-primary">Create</router-link>
        </div>
        <div class="container-fuild">        
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">ID </th>
                        <th scope="col">Image </th>
                        <th scope="col">Name </th>
                        <th scope="col">Type </th>
                        <th scope="col">Description </th>
                        <th scope="col">Unit Price </th>
                        <th scope="col">Promotion Price </th>
                        <th scope="col">Unit </th>
                        <th scope="col">New</th>    
                        <th scope="col">Action</th>     
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th scope="col">ID </th>
                        <th scope="col">Image </th>
                        <th scope="col">Name </th>
                        <th scope="col">Type </th>
                        <th scope="col">Description </th>
                        <th scope="col">Unit Price </th>
                        <th scope="col">Promotion Price </th>
                        <th scope="col">Unit </th>
                        <th scope="col">New</th>    
                        <th scope="col">Action</th>     
                    </tr>
                </tfoot>
                <tbody v-if="products.length > 0">
                    <tr v-for="(product,key) in products" :key="key">
                        <td>{{ product.id }}</td>  
                                    <!-- <td></td>                              -->
                        <td><img :src="getLogo(product.image)" height="200px" width="300px"/></td>
                        <td>{{product.name}}</td>
                        <td>{{product.id_type}}</td>
                        <td>{{product.description}}</td>
                        <td>{{product.unit_price}}</td>
                        <td>{{product.promotion_price}}</td>
                        <td>{{product.unit}}</td>
                        <td>{{product.new}}</td>
                        <td>
                            <router-link :to='{name:"productEdit",params:{id:product.id}}' class="btn btn-success">Edit</router-link>
                             <button type="button" @click="deleteProduct(product.id)" class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="4" align="center">Không có sản phẩm được tìm thấy</td>
                    </tr>
                </tbody>
            </table>
            
        </div>
    </div>
</template>
<script>
export default {
    name:"productList",
    data(){
        return {
            products:[],
           
        }
    },
    mounted(){
        this.getProducts()
    },
    methods:{
        async getProducts(){
            await this.axios.get('/api/product').then(response=>{
                    this.products = response.data
            }).catch(error=>{
                console.log(error)
                this.products = []
            })
        },
        deleteProduct(id){
            if(confirm("Are you sure to delete this product ?")){
                this.axios.delete(`/api/product/${id}`).then(response=>{
                    this.getProducts()
                }).catch(error=>{
                    console.log(error)
                })
            }
        },
        getLogo(Image){
        return 'images/'+Image;
        }
    }
}
</script>