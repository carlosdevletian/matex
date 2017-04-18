@if(auth()->user()->hasRole('admin'))
    <hr>
    @if($user->admin_comment != null)
        <h4 class="color-primary">Admin notes</h4>
        <a role="button" @click="openUserCommentModal({{ $user->id }}, '{{ $user->admin_comment }}')">
            <p style="color: grey">{{ $user->admin_comment }}</p>
        </a>
    @else
        <a role="button"
            @click="openUserCommentModal({{ $user->id }})">Add a note for this user</a>
    @endif
@endif