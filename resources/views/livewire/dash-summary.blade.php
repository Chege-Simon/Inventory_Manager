<div>
    <div class="container row">
        <div class="card text-center col-md-5 ml-5">
            <div class="card-header h4">
                Materials Low Alert
            </div>
            <div class="card-body text-left" style="max-height: 200px; overflow-y: scroll">
                @foreach($this->materials as $material)
                    @if($material->material_count <= $material->material_lower_threshold)
                        <div class="p-2">
                            <i class="fa fa-exclamation-circle text-danger mr-2" style="font-size: 1.5em" aria-hidden="true"></i>
                            <span>{{ $material->material_name  }} - {{ $material->material_quantity }} ({{ $material->material_count }}) pieces remain.</span><br>
                        </div>
                    @endif
                @endforeach
                <a href="/materials" class="btn btn-primary my-5 text-center">Go to Material</a>
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="card text-center col-md-5">
            <div class="card-header h4">
                Products Low Alert
            </div>
            <div class="card-body text-left" style="max-height: 200px; overflow-y: scroll">
                @foreach($this->products as $product)
                    @if($product->product_count <= $product->product_lower_threshold)
                        <div class="p-2">
                            <i class="fa fa-exclamation-circle text-danger mr-2" style="font-size: 1.5em" aria-hidden="true"></i>
                            <span>{{ $product->product_name  }} - {{ $product->product_quantity }} ({{ $product->product_count }}) pieces remain.</span><br>
                        </div>
                    @endif
                @endforeach
                <a href="/products" class="btn btn-primary my-5 text-center">Go to Products</a>
            </div>
        </div>
    </div>
    <div class="container row">
        <div class="card text-center col-md-5 ml-5">
            <div class="card-header h4">
                Materials Summary
            </div>
            <div class="card-body row" style="max-height: 215px; overflow-y: scroll">
                @foreach($this->materials as $material)
                    <span class="h6 font-weight-bold col-sm-3">{{ $material->material_name }}</span>
                    @if($material->material_count >= $material->material_upper_threshold )
                        <div class="progress col-sm-9">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {!! $material->material_count / $material->material_upper_threshold * 100 !!}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="{!! $material->material_upper_threshold !!}"></div>
                        </div>
                    @elseif($product->product_count < $material->material_upper_threshold & $material->material_count > $material->material_lower_threshold)
                        <div class="progress col-sm-9">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {!! $material->material_count / $material->material_upper_threshold * 100 !!}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="{!! $material->material_upper_threshold !!}"></div>
                        </div>
                    @else
                        <div class="progress col-sm-9">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: {!! $material->material_count / $material->material_upper_threshold * 100 !!}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="{!! $material->material_upper_threshold !!}"></div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="card text-center col-md-5">
            <div class="card-header h4">
                Products Summary
            </div>
            <div class="card-body row " style="max-height: 215px; overflow-y: scroll">
                @foreach($this->products as $product)
                    <span class="h6 font-weight-bold col-sm-3">{{ $product->product_name }}</span>
                    @if($product->product_count >= $product->product_upper_threshold )
                        <div class="progress col-sm-9">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {!! $product->product_count / $product->product_upper_threshold * 100 !!}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="{!! $product->product_upper_threshold !!}"></div>
                        </div>
                    @elseif($product->product_count < $product->product_upper_threshold & $product->product_count > $product->product_lower_threshold)
                        <div class="progress col-sm-9">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {!! $product->product_count / $product->product_upper_threshold * 100 !!}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="{!! $product->product_upper_threshold !!}"></div>
                        </div>
                    @else
                        <div class="progress col-sm-9">
                           <div class="progress-bar bg-danger" role="progressbar" style="width: {!! $product->product_count / $product->product_upper_threshold * 100 !!}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="{!! $product->product_upper_threshold !!}"></div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
