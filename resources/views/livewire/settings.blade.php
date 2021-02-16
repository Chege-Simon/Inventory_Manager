<div>
    <div class="container">
        <a class="btn btn-secondary m-2" wire:click="openUnitModal()" >New Measurement Unit</a>
    </div>
   <div class="container row">
       <table class="table col-md-4">
           <thead class="thead-dark">
           <tr>
               <th scope="col">Value</th>
               <th scope="col" class="text-center">Action</th>
           </tr>
           </thead>
           <tbody>
           @foreach($this->units as $unit)
               <tr>
                   <th scope="row">{{ $unit->value }}</th>
                   <td class="text-center">
                       <a href="#" wire:click="openModal({{ $unit->id }})" >
                           <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-pencil-square text-primary mr-4" viewBox="0 0 16 16">
                               <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                               <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                           </svg>
                       </a>
                       |
                       <a href="#" wire:click="confirmDelete({{ $unit->id }})" >
                           <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-trash text-danger ml-4" viewBox="0 0 16 16">
                               <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                               <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                           </svg>
                       </a>
                   </td>
               </tr>
           @endforeach
           </tbody>
       </table>
       <div class="col-md-4">

       </div>
       <div class="col-md-4">

       </div>
   </div>
    <!-- Add Measurement Modal -->
    @if($add_open)
        <div class="modal d-block" id="addMeasurementModel" tabindex="-1" role="dialog" aria-labelledby="addMeasurementModelLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title font-weight-bolder" id="addMeasurementModelLabel">Add Measurement Unit</h3>
                        <button type="button" wire:click="closeUnitModal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form  wire:submit.prevent="addUnit">
                            <div class="form-group">
                                <label for="new_measurement_unit">Measurement Unit:</label>
                                <input type="text" class="form-control" class="@error('new_measurement_unit') is-invalid @enderror" wire:model="new_measurement_unit" id="new_measurement_unit"  required>
                                @error('new_measurement_unit') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="modal-footer">
                                <button type="button" wire:click="closeUnitModal" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cancel</button>
                                <button type="submit" class="btn btn-success">Action</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
<!-- Edit Measurement Modal -->
    @if($open)
        <div class="modal d-block" id="editMeasurementModel" tabindex="-1" role="dialog" aria-labelledby="editMeasurementModelLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title font-weight-bolder" id="editMeasurementModelLabel">Modify Measurement Unit</h3>
                        <button type="button" wire:click="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form  wire:submit.prevent="modifyUnit">
                            <div class="form-group">
                                <label for="measurement_unit">Measurement Unit:</label>
                                <input type="text" class="form-control" class="@error('measurement_unit') is-invalid @enderror" wire:model="measurement_unit" id="measurement_unit"  required>
                                @error('measurement_unit') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="modal-footer">
                                <button type="button" wire:click="closeModal" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cancel</button>
                                <button type="submit" class="btn btn-success">Action</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
