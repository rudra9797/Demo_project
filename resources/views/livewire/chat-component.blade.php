<div>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card chat-app">
                <div id="plist" class="people-list">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                    <ul class="list-unstyled chat-list mt-2 mb-0">

                        @foreach ($users as $user)
                            <li class="clearfix @if ($chat_user_id == $user->id) active @endif"
                                wire:click="$emit('selectedUser',{{ $user->id }})">
                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
                                <div class="about">
                                    <div class="name">{{ $user->name }}</div>
                                    <div class="status"> <i class="fa fa-circle offline"></i> left 7 mins ago </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="chat">
                    <div class="chat-header clearfix">
                        <div class="row">
                            <div class="col-lg-6">
                                @if ($selectedUser)
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                                    </a>
                                    <div class="chat-about">
                                        <h6 class="m-b-0">{{ $selectedUser->name }}</h6>
                                        <small>Last seen: 2 hours ago</small>
                                    </div>
                                @else
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                                    </a>
                                    <div class="chat-about">
                                        <h6 class="m-b-0">Null</h6>
                                        {{-- <small>Last seen: 2 hours ago</small> --}}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="chat-history" id="messages">
                        <ul class="m-b-0">
                            @if (count($messages) > 0)
                                @foreach ($messages as $message)
                                    @if ($message->user_id == auth()->user()->id)
                                        <li class="clearfix">
                                            <div class="message-data text-right view-avtar">
                                                <span class="message-data-time">10:10 AM, Today</span>
                                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png"
                                                    alt="avatar">
                                            </div>
                                            <div class="message other-message float-right"> {{ $message->body }}
                                            </div>
                                        </li>
                                    @else
                                        <li class="clearfix">
                                            <div class="message-data">
                                                <span class="message-data-time">10:12 AM, Today</span>
                                            </div>
                                            <div class="message my-message"> {{ $message->body }} </div>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="chat-message clearfix">
                        <div class="input-group mb-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text" wire:click='send'><i class="fa fa-send"></i></span>
                            </div>
                            <input type="text" wire:model="message" class="form-control"
                                placeholder="Enter text here...">
                        </div>
                        @error('message')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            // when I scroll to top I fire the event load more to show more old messages
            $('#messages').scroll(function() {
                debugger;
                var top = $('#messages').scrollTop();

                console.log(top);

                if (top == 0) {
                    window.livewire.emit('loadMore')
                }
            });


            // after selecting the user I fire the event scroll to scroll the messages box to bottom
            // window.livewire.on('scroll', function() {
            //     $('#messages').animate({
            //         scrollTop: $('#messages')[0].scrollHeight
            //     }, "slow");
            // })

            // After selecting a user, scroll the messages box to the bottom
            window.livewire.on('scroll', function() {
                var messagesBox = $('#messages');
                messagesBox.scrollTop(messagesBox.prop('scrollHeight'));
            });
        });

        // $(document).ready(function() {
        //     $('#messagesData').scroll(function() {

        //         var scrollTop = $(this).scrollTop();
        //         console.log(scrollTop);
        //         var scrollHeight = $(this).prop('scrollHeight');
        //         var height = $(this).height();

        //         if (scrollTop === 0) {
        //             window.livewire.emit('loadMore');
        //         }
        //     });
        // });
    </script>
@endpush
