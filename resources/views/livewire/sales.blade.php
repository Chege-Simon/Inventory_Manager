<div>
    <div class="container">
        <div>
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        <div class="card">
            @if($open)
                <livewire:new-sale/>
            @endif
            <div class="card-header row">
                <h3 class="card-title col-md-5">All Sales</h3>
                <input wire:model="searchTerm" type="text" class="form-control rounded col-md-2 ml-5" placeholder="Search...">
                {{--                <a class="btn btn-secondary col-md-1 form-control ml-1">Import</a>--}}
                <a wire:click="export" class="btn btn-secondary col-md-1 form-control ml-1">Export</a>
                <div wire:loading class="spinner-border-sm text-dark text-success ml-auto" role="status">
                    <span class="sr-only">Just a moment...</span>
                </div>
                {{--                <a class="btn btn-success col-md-2 form-control ml-1" >Add to Stock</a>--}}
                @if(!$open)
                    <a wire:click="$set('open',true)" class="btn btn-success col-md-2 form-control ml-1">New Sale</a>
                @else
                    <a wire:click="$set('open',false)" class="btn btn-danger col-md-2 form-control ml-1">Close</a>
                @endif
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-striped">
                    <thead class="thead-dark" >
                    @foreach($headers as $key => $value)
                        <th style="cursor: pointer" wire:click="sort('{{ $key }}')">
                            @if($sortColumn == $key)
                                <span>{!! $sortDirection == 'asc' ? '&#8659;':'&#8657;' !!}</span>
                            @endif
                            {{ is_array($value) ? $value['label'] : $value }}
                        </th>
                    @endforeach
                    </thead>
                    <tbody>
                    @if(count($sales))
                        @foreach($sales as $sale)
                            <tr>
                                @foreach($headers as $key => $value)
                                    <td>
                                        {!! is_array($value) ? $value['func']($sale->$key) :$sale->$key!!}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="{{ count($headers) }}"><h2>No Results found!</h2></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-sm-6" style="">
                        {{ $sales->links('pagination::bootstrap-4') }}
                    </div>
                    <div class="clo-sm-6">  </div>
                </div >
            </div>
        </div>
    </div>
</div>
