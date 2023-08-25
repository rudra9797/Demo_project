<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (!empty($educationFirst) && !empty($educationSecond))
                    <button class="btn btn-primary" wire:click="add">Add</button>
                @endif

                <div class="card">
                    <div class="card-header text-right">
                        <button class="btn btn-success" wire:click="showModel('1')">Edit</button>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">School Name <br>{{ @$educationFirst->school_name }}</div>
                            <div class="col-md-6">Degree <br>{{ @$educationFirst->degree }}</div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">Year <br>{{ @$educationFirst->year }}</div>
                            <div class="col-md-6">Marks <br>{{ @$educationFirst->marks }}</div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header text-right">
                        <button class="btn btn-success" wire:click="showModel('2')">Edit</button>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">School Name <br>{{ @$educationSecond->school_name }} </div>
                            <div class="col-md-6">Degree <br>{{ @$educationSecond->degree }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">Year <br>{{ @$educationSecond->year }}</div>
                            <div class="col-md-6">Marks <br>{{ @$educationSecond->marks }}</div>
                        </div>
                    </div>
                </div>

                @foreach ($educationData as $key => $data)
                    <div class="card">
                        <div class="card-header text-right">
                            <button class="btn btn-danger" wire:click="remove('{{ $data['education_id'] ?? null }}','{{ $key+3 }}')"> remove</button>
                            <button class="btn btn-success" wire:click="showModel('{{ $data['education_id'] ?? null }}','{{ 0 }}')">Edit</button>

                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">School Name <br>{{ $data['school_name'] ?? null }}</div>
                                <div class="col-md-6">Degree <br>{{ $data['degree'] ?? null }}</div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">Year <br>{{ $data['year'] ?? null }}</div>
                                <div class="col-md-6">Marks <br>{{ $data['marks'] ?? null }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="showEducationModel" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="email"
                            class="col-md-4 col-form-label text-md-end">{{ __('School Name') }}</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" wire:model="school_name" required>

                            @error('school_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">{{ __('Degree') }}</label>

                        <div class="col-md-6">
                            <input type="text" wire:model="degree" class="form-control" required>

                            @error('degree')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">{{ __('Marks') }}</label>

                        <div class="col-md-6">
                            <input type="text" wire:model="marks" class="form-control" required>

                            @error('marks')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">{{ __('Year') }}</label>
                        <div class="col-md-6">
                            <input type="text" wire:model="year" class="form-control" required>
                            @error('year')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" wire:click="store" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            window.livewire.on('showModel', () => {
                $('#showEducationModel').modal('show');
            });
        })
        $(document).ready(function() {
            window.livewire.on('cloaseModal', () => {
                $('#showEducationModel').modal('hide');
            });
        })
    </script>
@endpush
