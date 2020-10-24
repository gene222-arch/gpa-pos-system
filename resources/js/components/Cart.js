import Axios from 'axios';
import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import Swal from 'sweetalert2';
import {sum} from 'lodash';

class Cart extends Component {

/**
 * 
 * @param {props} 
 * setting up the state variables 
 * @property {this.state}
 * Where different properties of this object is stored
 * @function {Class Functions} 
 * 
 */
    constructor(props) {

        super(props)
        this.state = {
            cart: [],
            products: [],
            customers: [],
            barcode: '',
            qty: '',
            search: '',
            customer_id: '',

        };

        this.loadCart = this.loadCart.bind(this);
        this.loadProducts = this.loadProducts.bind(this);
        this.handleOnChangeBarcode = this.handleOnChangeBarcode.bind(this);
        this.handleScanBarcode = this.handleScanBarcode.bind(this);
        this.handleOnChangeQty = this.handleOnChangeQty.bind(this);
        this.handleClickDelete = this.handleClickDelete.bind(this);
        this.handleEmptyCart = this.handleEmptyCart.bind(this);
        this.handleChangeSearch = this.handleChangeSearch.bind(this);
        this.handleSearch = this.handleSearch.bind(this);
        this.addProductToCart = this.addProductToCart.bind(this);
        this.loadCustomers = this.loadCustomers.bind(this);
        this.setCustomerId = this.setCustomerId.bind(this);
        this.handleClickSubmit = this.handleClickSubmit.bind(this);
    }

// Run on load
    componentDidMount() 
    {
        this.loadCart();
        this.loadProducts();
        this.loadCustomers();
    }

/**
 * Load user_cart data
 */
    loadCart() 
    {
        Axios.get('/admin/cart')
        .then(res => this.setState({cart: res.data}))
        .catch(err =>             
            Swal.fire(
                'Error!',
                err.response.data.message,
                'error'
        ));
    }

    loadCustomers()
    {
        Axios.get('/admin/customers')
        .then(res => this.setState({ customers: res.data }))
        .catch(err => {
            Swal.fire(
                'Error!',
                err.response.data.message,
                'error'
            )
        })
    }


    loadProducts(search = '') 
    {
        const query = search ? `?search=${ search }` : '';
        Axios.get(`/admin/products${ query }`)
        .then(res => this.setState({products: res.data.data}))
        .catch(err => {
            Swal.fire(
                'Error!',
                err.response.data.message,
                'error'
            )
        });
    }
/**
 * 
 * @param {event} event is an object of an action { input, clicked, submit, mouseover} which contains the 
 * information about the constructor Input/Button/Form 
 * 
 * Function purpose: Setting the state.barcode data by passing the event value
 */
    handleOnChangeBarcode(event) 
    {
        this.setState({barcode: event.target.value})
    }


/**
 * FORM SUBMISSION
 * Function purpose: handling the barcode data when Submitted
 * @param event purpose: preventing the FORM from submitting
 * @const {this.state.barcode} barcode fetching the BARCODE data from the State that was loaded 
 */
    handleScanBarcode(event) 
    {
        event.preventDefault();
        const {barcode} = this.state;

        if (barcode) {

            Axios.post('/admin/cart', { barcode })
            .then(res => 
            {
                this.loadCart();
                this.setState({barcode: ''});
            })
            .catch(err => 
            {
                Swal.fire(
                    'Error!',
                    err.response.data.errors.barcode[0],
                    'error'
                )
            });

        }
    }

/**
 * 
 * @param {*} product_id the data which is loaded 
 * @param {*} qty the data which is loaded
 * Function purpose: Setting the cart.quantity {Cart.state property} 
 */
    handleOnChangeQty(product_id, qty) 
    {
        const cart = this.state.cart.map(c => {

            if (c.id == product_id) {

                c.pivot.quantity = qty;
            }

            return c;
        });

        this.setState({cart});

        Axios.post('/admin/cart/change-qty', 
        {
            product_id,
            quantity: qty
        })
        .then(res => {})
        .catch(err => 
        {
            Swal.fire(
                'Error!',
                err.response.data.errors.quantity[0],
                'error'
            )
        });

    }

// Get total value
    getTotal(cart) 
    {
        return  sum(cart.map(c => c.pivot.quantity * c.price)); 
    }

    handleClickDelete(product_id) 
    {
        Axios.post(`/admin/cart/delete-user_cart-product`, 
        {
            product_id, 
            _method: 'DELETE'
        })
        .then(res => this.setState({ cart: this.state.cart.filter(c => c.id != product_id) }))
        .catch(err => {
            Swal.fire(
                'Error!', 
                err.response.data.message, 
                'error'
            );
        });
    }

    handleEmptyCart() 
    {
        Axios.post('/admin/cart/empty',{_method: 'DELETE'})
        .then(res => this.setState({ cart: [] }))
        .catch(err => console.log(err.response.data))
    }
/**
 * 
 * @param {*} event 
 * Function purpose: Set search data in state 
 */
    handleChangeSearch(event) 
    {
        this.setState({ search: event.target.value });
    }

    handleSearch(event) 
    {
        this.loadProducts(this.state.search);
    }   

/**
 * 
 * @param {*} barcode 
 * Function purpose: Add new product to cart
 */
    addProductToCart(barcode) 
    {
        Axios.post('/admin/cart', { barcode })
        .then(res => 
        {
            this.loadCart();
            this.setState({barcode: ''});
        })
        .catch(err => 
        {
            Swal.fire(
                'Error!',
                err.response.data.errors.barcode[0],
                'error'
            )
        });
    }

    setCustomerId(event) 
    {
        this.setState({ customer_id: event.target.value })
        console.log(event.target.value)
    }

    handleClickSubmit()
    {
        Swal.fire({
            title: 'Received Amount',
            input: 'text',
            inputValue: this.getTotal(this.state.cart),
            showCancelButton: true,
            confirmButtonText: 'Buy',
            showLoaderOnConfirm: true,
            preConfirm: (amount) => {
                return Axios.post('/admin/orders', 
                {
                    customer_id: this.state.customer_id,
                    amount
                })
                .then(res => {
                    this.loadCart();
                    return res.data;
                })
                .catch(err => Swal.showValidationMessage(err.response.data.message))
            },
            allowOutsideClick: () => !Swal.isLoading()
          }).then((result) => {
            if (result.isConfirmed) {
                
            }
          })
    }

    render() {
    // destructuring
        const {cart, products, customers, customer_id, barcode} = this.state;
        return (
            <div className="row">
                <div className="col-md-8 col-lg-6">
                    <div className="row">
                        <div className="col">
                        {/* Handling barcode */}
                            <form onSubmit={this.handleScanBarcode}>
                                <input 
                                    type="text" 
                                    className="form-control" 
                                    placeholder="Scan Barcode..."
                                    value={barcode}
                                    onChange={this.handleOnChangeBarcode}
                                    />
                            </form>
                        </div>
                        <div className="col">
                            <select 
                                className="form-control"
                                onChange = { this.setCustomerId }
                                >
                                <option>Walking Customer</option>
                                {customers.map(customer => (
                                    <option key={ customer.id } value={customer.id}>{ customer.first_name }</option>
                                ))}
                            </select>
                        </div>
                    </div>

                    <div className="user-cart">
                        <div className="card mt-2">
                            <div className="card-body">
                                <table className="table table-striped mb-4">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    {/* Iteration on fetched data  */}
                                        { cart.map(c => (
                                            <tr key={c.id}>
                                                <td>{c.product_name}</td>
                                                <td>
                                                {/* Handling on quantity change */}
                                                    <input 
                                                        type="text" 
                                                        name="quantity" 
                                                        className="form-control form-control-sm qty" 
                                                        value={c.pivot.quantity}
                                                        onChange = {
                                                            () => this.handleOnChangeQty(c.id, event.target.value)
                                                        }

                                                        />
                                                </td>
                                                <td>
                                                    { window.APP.currency_symbol } { (c.price * c.pivot.quantity).toFixed(2) }
                                                </td>
                                                <td>
                                                {/* Handling delete event */}
                                                    <button 
                                                    className="btn btn-danger"
                                                    onClick = { () => this.handleClickDelete(c.id) }
                                                    >
                                                        <i className="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                    <tbody>
                                        <tr className="border border-primary bg-primary">
                                            <td>Total: </td>
                                            <td></td>
                                            <td></td>
                                        {/* Handling total */}
                                            <td>{window.APP.currency_symbol} { this.getTotal(cart) }</td>
                                        </tr>
                                    </tbody>
                                </table>
                            
                                <div className="row">
                                    <button 
                                        className="btn btn-success btn-block"
                                        disabled={ !cart.length }
                                        onClick = { this.handleClickSubmit}
                                        >Submit
                                    </button>
                                {/* Handling on cancelling purchase/setting cart to empty */}
                                    <button 
                                        className="btn btn-danger btn-block"
                                        onClick = {this.handleEmptyCart}
                                        disabled={ !cart.length }
                                        >Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
                
                <div className="col-md-4 col-lg-6 items__container">
                    <div className="search-product">
                        <input 
                            type="text" 
                            className="form-control mb-4" 
                            placeholder="Search Product ..."
                            onChange = {this.handleChangeSearch}
                            onKeyUp = {this.handleSearch}
                            />
                    </div>
                    <div className="order__product">
                        <div className="item-container">
                        {/* Products */}
                            { products.map(p => (    
                                <div key={p.id} 
                                    className="item" 
                                    onClick ={ () => this.addProductToCart(p.barcode)}>
                                    <div className="row">
                                        <div className="col item-content">
                                            <div className="product-img">
                                                <img src={ p.image_url }/>
                                            </div>
                                            <div className="product-name">
                                                <h5>{ p.product_name }</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            )) }
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Cart;

let cart = document.getElementById('cart');
if (cart) {
    ReactDOM.render(<Cart />, cart)
}

/**
 * If an argument is passed add event keyword/parentheses
 * 
 * function handleSomething(data)
 * {
 *      Do something
 * }
 * 
 * onClick = { event => this.handleSomethings(data.id)}
 * onClick = { () => this.handleSomethings(data.id)}
 */