<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3>Users</h3>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($users as $user)
                        <button wire:click="selectUser({{ $user->id }})" 
                                class="list-group-item list-group-item-action {{ $selectedUser && $selectedUser->id == $user->id ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">{{ $user->first_name }} {{ $user->last_name }}</h5>
                                    <small>{{'@'.$user->username }}</small>
                                </div>
                                @if($user->messages->where('is_from_admin', false)->where('read', false)->count() > 0)
                                    <span class="badge bg-primary rounded-pill">
                                        {{ $user->messages->where('is_from_admin', false)->where('read', false)->count() }}
                                    </span>
                                @endif
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        @if($selectedUser)
            <div class="card">
                <div class="card-header">
                    <h3>Chat with <span class="text-primary">
                        {{ $selectedUser->first_name }} {{ $selectedUser->last_name }}    
                    </span></h3>
                </div>
                <div class="card-body" style="height: 400px; overflow-y: auto;">
                    <div class="chat-messages">
                        @foreach($messages->sortBy('sent_at') as $message)
                            <div class="message mb-3 {{ $message->is_from_admin ? 'text-end' : '' }}">
                                <div class="message-content d-inline-block p-2 rounded {{ $message->is_from_admin ? 'bg-primary text-white' : 'bg-light' }}">
                                    {{ $message->content }}
                                    <br>
                                    <small style="color: #C7C8CC">
                                        {{ $message->sent_at->format('M d, Y H:i') }}
                                        @if($message->is_from_admin)
                                            <button wire:click="deleteMessage({{ $message->id }})" 
                                                    class="btn btn-sm btn-link text-danger">
                                                <i class="la la-trash"></i>
                                            </button>
                                        @endif
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <form wire:submit.prevent="sendMessage">
                        <div class="input-group">
                            <input type="text" wire:model.defer="message" class="form-control" placeholder="Type your message...">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                        @error('message') <span class="text-danger">{{ $message }}</span> @enderror
                    </form>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body text-center">
                    <h3>Select a user to start chatting</h3>
                </div>
            </div>
        @endif
    </div>
</div>