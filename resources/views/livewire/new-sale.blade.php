<div>
    <form class="container row"  wire:submit.prevent="newSale">
        <div class="col-md-3">
            <label for="customer" class="mr-2">Customer Name</label>
            <input type="text" class="form-control" class="@error('customer') is-invalid @enderror" wire:model="customer" id="customer"  required>
            @error('customer') <span class="error text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-3">
            <label for="product_id" class="mr-2">Product</label>
            <select class="custom-select" class="@error('product_id') is-invalid @enderror" wire:model="product_id" id="product_id" required>
                <option selected>Select Product:</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->product_name }} -- {{ $product->product_quantity }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="count" class="mr-2">Count</label>
            <input type="number" class="form-control" class="@error('count') is-invalid @enderror" wire:model="count" id="count"  required>
            @error('count') <span class="error text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-3">
            <label for="price" class="mr-2">Price: Ksh</label>
            <input type="number" class="form-control" class="@error('price') is-invalid @enderror" wire:model="price" id="price"  required>
            @error('price') <span class="error text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-5 m-3">
            <div>
                <p><span class="lead">Total: </span>{{ $this->price * $this->count }}</p>
            </div>
        </div>
        <br>
        <div class="col-md-5 m-3">
            <button type="submit" class="btn btn-success">Action</button>
        </div>
    </form>
</div>
