<div>
    <div class="row">
        <div class="col-md-4">

        </div>
        <form  wire:submit.prevent="addNewMaterial" class="col-md-4">
            <div class="form-group">
                <label for="material_name">Material Name:</label>
                <input type="text" class="form-control" class="@error('material_name') is-invalid @enderror" wire:model="material_name" id="material_name" required>
                @error('material_name') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="unit">Unit of Measurement:</label>
                <select class="custom-select" class="@error('unit') is-invalid @enderror" wire:model="unit" id="unit" required>
                    <option selected>Unit of Measurement</option>
                    @foreach($this->units as $unit)
                        <option value="{{ $unit->value }}">{{ $unit->value  }}</option>
                    @endforeach
                </select>
                @error('unit') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" class="form-control" class="@error('quantity') is-invalid @enderror" wire:model="quantity" id="quantity" required>
                @error('quantity') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="upper_threshold">Upper Threshold:</label>
                <input type="number" class="form-control" class="@error('upper_threshold') is-invalid @enderror" wire:model="upper_threshold" id="upper_threshold" required placeholder="Must be more than lower threshold">
                @error('upper_threshold') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="lower_threshold">Lower Threshold:</label>
                <input type="number" class="form-control" class="@error('lower_threshold') is-invalid @enderror" wire:model="lower_threshold" id="lower_threshold" required placeholder="Must be less than upper threshold">
                @error('lower_threshold') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Action</button>
            </div>
        </form>

        <div class="col-md-4"></div>
    </div>
</div>
