
const Homepage = () => import('./components/Hompage.vue' )
const ProductList = () => import('./components/products/List.vue' )
const ProductAdd = () => import('./components/products/Add.vue' )
const ProductEdit = () => import('./components/products/Edit.vue' )

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Homepage
    },
    {
        name: 'productList',
        path: '/product',
        component: ProductList
    },
    {
        name: 'productAdd',
        path: '/product/add',
        component: ProductAdd
    },
    {
        name: 'productEdit',
        path: '/product/:id/edit',
        component: ProductEdit
    }
]