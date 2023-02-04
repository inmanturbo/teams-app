@isset(app()['team'])
    <img src="{{app('team')->profile_photo_url}}" alt="">
@endisset