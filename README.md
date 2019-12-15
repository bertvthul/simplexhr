# Make XHR Requests simple for Laravel

This package provides a way to make XHR requests simple for your Laravel app. 

```html
<span class="btn" data-simplexhr="Product.addToCart" data-values="{'id': 1}">Order</span>
```

In data-simplexhr you'll provide the controllername and the functionname to call. The `data-values` can be used to provide the values needed to proces the request. When added to a form, all the values in the form are authomatically send.

## Installation

You can install the package via composer:

```bash
composer require bertvthul/simplexhr
```

Add the service provider to the providers array in `config\app.php`;

```php
Bertvthul\Simplexhr\SimplexhrServiceProvider::class,
```

And make sure the js is loaded by adding the following to your app.js;

```js
require('./../../vendor/bertvthul/simplexhr/src/js/simplexhr.js');
```

## Usage

In your blade files add `data-simplexhr="Controller.function"` to an element that is clickable or to a form. You'll need to provide a controller and a function, separated by a dot.

```html
<span class="btn" data-simplexhr="Product.addToCart" data-values="{'id': 1}">Order</span>
```

Use the `data-values` to send variables to the function.

You can also add it to a form:

```html
<form data-simplexhr="Product.addToCart" onchange>
	<input type="text" name="count">
	<input type="hidden" name="object" value="1">
</form>
```

You can use hidden fields to provide extra data. The `onchange` means the form is submitted on any change. Delete it to only send the form on a custom submit.

In the function in your controller you could do the following;

```php
public function addToCart(Request $request) 
{
    session(['Product.cart.'.$request->input('object') => $request->input('count')]);
    $response = [
    	'msg' => 'Item added to your cart!',
        'html' => [
            '#book-btn'     => view('product.bookbutton')->render(),
            '#cart-items'   => view('cart.items')->render(),
        ],
    ];
    
    return response()->json($response);
}
```

The html response is handled by the package. The keys are the html elements to replace, the values the content to replace them with.

You can return whatever you like. The script calls the js function `xhrCustomCallback` when it exists. You can handle the other json response, like a message to show after the reponse:

```js
$.xhrCustomCallback = function(data) {
	if ('msg' in data) {
		$('#toast').find('.toast-body').html(data.msg);
		$('#toast').toast('show');
	}
}
```

## License

The MIT License (MIT).