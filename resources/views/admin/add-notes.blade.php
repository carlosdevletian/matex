@if(auth()->user()->hasRole('admin'))
    <hr>
    <p class="Card__title" style="margin-left: 15px">Admin notes</p>
    @if($user->admin_comment != null)
        <a role="button" @click="openUserCommentModal({{ $user }})">
            <p style="color: grey">{{ $user->admin_comment }}</p>
        </a>
    @else
        <a role="button"
            @click="openUserCommentModal({{ $user }})">Add a note for this user</a>
    @endif
@endif