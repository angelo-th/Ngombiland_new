<div>
    <form wire:submit.prevent="save">
        <div>
            <label for="title">Title</label>
            <input type="text" id="title" wire:model="title">
            @error('title') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="description">Description</label>
            <textarea id="description" wire:model="description"></textarea>
            @error('description') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="total_amount">Total Amount</label>
            <input type="number" id="total_amount" wire:model="total_amount">
            @error('total_amount') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="total_shares">Total Shares</label>
            <input type="number" id="total_shares" wire:model="total_shares">
            @error('total_shares') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="price_per_share">Price Per Share</label>
            <input type="number" id="price_per_share" wire:model="price_per_share">
            @error('price_per_share') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="funding_deadline">Funding Deadline</label>
            <input type="date" id="funding_deadline" wire:model="funding_deadline">
            @error('funding_deadline') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="expected_roi">Expected ROI (%)</label>
            <input type="number" id="expected_roi" wire:model="expected_roi">
            @error('expected_roi') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="management_fee">Management Fee (%)</label>
            <input type="number" id="management_fee" wire:model="management_fee">
            @error('management_fee') <span>{{ $message }}</span> @enderror
        </div>

        <button type="submit">Create Project</button>
    </form>
</div>