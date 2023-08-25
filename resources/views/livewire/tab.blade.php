<div>
    <div class="card p-3 shadow" style="max-width: 1000px;" x-data="{ currentTab: $persist('home') }">
        <h1></h1>
        <h2 class="text-center p-3">Card with Tabs</h2>
        <nav>
            <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                <button class="nav-link" @click.prevent="currentTab = 'home'" :class="{ 'active': currentTab === 'home' }"
                    data-bs-toggle="tab" type="button" role="tab" aria-controls="nav-home"
                    aria-selected="true">Home</button>
                <button class="nav-link" @click.prevent="currentTab = 'profile'"
                    :class="{ 'active': currentTab === 'profile' }" data-bs-toggle="tab" type="button" role="tab"
                    aria-controls="nav-profile" aria-selected="false">Profile</button>
                <button class="nav-link" @click.prevent="currentTab = 'contact'"
                    :class="{ 'active': currentTab === 'contact' }" data-bs-toggle="tab" type="button" role="tab"
                    aria-controls="nav-contact" aria-selected="false">Contact</button>

                <h1 x-text="currentTab"></h1>

            </div>
        </nav>
        <div class="tab-content p-3 border bg-light" id="nav-tabContent">
            <h1 x-text="currentTab"></h1>
            <div class="tab-pane fade " :class="{ 'active show': currentTab === 'home' }" id="nav-home" role="tabpanel"
                aria-labelledby="nav-home-tab">
                <p><strong>This is some placeholder content the Home tab's associated content.</strong>
                    Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps
                    classes to control the content visibility and styling. You can use it with tabs, pills, and any
                    other <code>.nav</code>-powered navigation.</p>
            </div>
            <div class="tab-pane fade" :class="{ 'active show': currentTab === 'profile' }" id="nav-profile"
                role="tabpanel" aria-labelledby="nav-profile-tab">
                <p><strong>This is some placeholder content the Profile tab's associated content.</strong>
                    Clicking another tab will toggle the visibility of this one for the next.
                    The tab JavaScript swaps classes to control the content visibility and styling. You can use it with
                    tabs, pills, and any other <code>.nav</code>-powered navigation.</p>
            </div>
            <div class="tab-pane fade" :class="{ 'active show': currentTab === 'contact' }" id="nav-contact"
                role="tabpanel" aria-labelledby="nav-contact-tab">
                <p><strong>This is some placeholder content the Contact tab's associated content.</strong>
                    Clicking another tab will toggle the visibility of this one for the next.
                    The tab JavaScript swaps classes to control the content visibility and styling. You can use it with
                    tabs, pills, and any other <code>.nav</code>-powered navigation.</p>
            </div>
        </div>
    </div>


    <button type="button" class="btn btn-primary" wire:click="" data-toggle="modal" data-target="#exampleModal">
        Launch demo modal
    </button>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach ($dynamicFields as $index => $field)
                        <label>{{ $field['label'] }}</label>
                        <input type="text" wire:model="dynamicFields.{{ $index }}.value">
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
