<form method="post" action="{{ route('contact') }}">
	<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
        <label for="email" class="control-label">{{ $errors->has('email') ? $errors->first('email') : 'Your email'}}</label>
        <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ Request::old('email') }}" required>
    </div>
	<div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
        <label for="subject" class="control-label">{{ $errors->has('subject') ? $errors->first('subject') : 'Subject'}}</label>
        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" value="{{ Request::old('subject') }}" required>
    </div>
	<div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
        <textarea type="text" rows="10" class="form-control" name="body" id="body" placeholder="Enter text here..." value="{{ Request::old('body') }}" required></textarea>
    </div>
    <button type="submit" class="btn btn-default btn-block">Send</button>
	{{ csrf_field() }}
</form>
