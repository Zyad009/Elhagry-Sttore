<x-models.show title="Add Special Offer">
        
        <form method="post" wire:submit.prevent ="submit" novalidate class="">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for=""> Discount Type <span class="text-danger">*</label>
                        <select wire:model.blur="discount_type" class="form-control">
                            <option value="">Select Discount Type</option>
                            <option value="percentage">Percentage</option>
                            <option value="value">Value</option>
                        </select>
                        <x-message.error name="discount_type"></x-message.error>
                    </div>
                    
                    <div class="col-md-6">
                        <label>Discount <span class="text-danger">*</label>
                        <input type="number" min="1" wire:model.blur="discount" class="form-control">
                        <x-message.error name="discount"></x-message.error>
                    </div>
                </div>
                <div class="row mb-3">
            
                    <div class="col-md-6">
                        <label>Start Date <span class="text-danger">*</label>
                        <input type="datetime-local" wire:model.blur="start_date" class="form-control">
                        <x-message.error name="start_date"></x-message.error>
                    </div>
            
                    <div class="col-md-6">
                        <label>End Date <span class="text-danger">*</label>
                        <input type="datetime-local" wire:model.blur="end_date" class="form-control">
                        <x-message.error name="end_date"></x-message.error>
                    </div>
            
                </div>
                <x-button.submit.create></x-button.submit.create>
            </form>
</x-models.show>