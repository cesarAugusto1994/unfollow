@extends('adminlte::page')

@section('content_header')
    <h1>Perfil</h1>
@stop

@section('content')

  <div class="row">
    <div class="col-md-2">

      <!-- Profile Image -->
      <div class="box box-primary">
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle" src="{{ $user->informations->profile_picture }}" alt="User profile picture">

          <h3 class="profile-username text-center">{{ $user->informations->full_name }}</h3>

          <p class="text-muted text-center">{{ $user->informations->username }}</p>

          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Publicações</b> <a class="pull-right">{{ $user->counts->media }}</a>
            </li>
            <li class="list-group-item">
              <b>Seguindo</b> <a class="pull-right">{{ $user->counts->follows }}</a>
            </li>
            <li class="list-group-item">
              <b>Seguido</b> <a class="pull-right">{{ $user->counts->followed_by }}</a>
            </li>
          </ul>

          <!--<a href="{{ $user->permalink }}" target="_blank" class="btn btn-yahoo btn-block"><b>Acessar Perfil</b></a>-->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

      <!-- About Me Box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Sobre</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          <strong><i class="fa fa-user margin-r-5"></i> Biografia</strong>

          <p class="text-muted">
            {{ $user->informations->bio }}
          </p>

          <hr>

          <strong><i class="fa fa-at margin-r-5"></i> Website</strong>

          <p class="text-muted">
            {{ $user->informations->website }}
          </p>


        </div>
      </div>
    </div>

    <div class="col-md-10">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Atividade</a></li>
          <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Timeline</a></li>
          <li><a href="#settings" data-toggle="tab">Configurações</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="activity">
            <div class="row">
            @foreach($user->medias as $media)
            <div class="col-lg-3">
                <div class="post">
              <div class="user-block">
                <img class="img-circle img-bordered-sm" src="{{ $media->user->informations->profile_picture }}" alt="User Image">
                    <span class="username">
                      <a href="#">{{ $media->user->full_name }}</a>
                    </span>
                <span class="description"></span>
              </div>
              <div class="row margin-bottom">
                <div class="col-sm-12">
                  <a href="{{ $media->link }}">
                  <img class="img-responsive" src="{{ $media->images->last()->url }}" alt="Photo"></a>
                </div>
              </div>

              <ul class="list-inline">
                <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Likes <b>{{ $media->likes }}</b></a></li>

                @foreach($media->usersInPhoto as $userInPhoto)
                    <li><a href="{{ route('person_profile', ['id' => $userInPhoto->user->api_id]) }}"> {{ '@' . $userInPhoto->user->username }}</a></li>
                @endforeach

                <li class="pull-right">
                  <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                    ({{ $media->comments }})</a></li>
              </ul>
              <a class="btn btn-block btn-default" target="_blank" href="{{ $media->link }}">Ir para o Instagram</a>
            </div>
            </div>
            @endforeach
          </div>
          </div>
        <!--
          <div class="tab-pane" id="timeline">
            <ul class="timeline timeline-inverse">
              <li class="time-label">
                    <span class="bg-red">
                      10 Feb. 2014
                    </span>
              </li>
              <li>
                <i class="fa fa-envelope bg-blue"></i>

                <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                  <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                  <div class="timeline-body">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                    weebly ning heekya handango imeem plugg dopplr jibjab, movity
                    jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                    quora plaxo ideeli hulu weebly balihoo...
                  </div>
                  <div class="timeline-footer">
                    <a class="btn btn-primary btn-xs">Read more</a>
                    <a class="btn btn-danger btn-xs">Delete</a>
                  </div>
                </div>
              </li>
              <li>
                <i class="fa fa-user bg-aqua"></i>

                <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                  <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                  </h3>
                </div>
              </li>
              <li>
                <i class="fa fa-comments bg-yellow"></i>

                <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                  <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                  <div class="timeline-body">
                    Take me to your leader!
                    Switzerland is small and neutral!
                    We are more like Germany, ambitious and misunderstood!
                  </div>
                  <div class="timeline-footer">
                    <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                  </div>
                </div>
              </li>
              <li class="time-label">
                    <span class="bg-green">
                      3 Jan. 2014
                    </span>
              </li>
              <li>
                <i class="fa fa-camera bg-purple"></i>

                <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                  <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                  <div class="timeline-body">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                  </div>
                </div>
              </li>
              <li>
                <i class="fa fa-clock-o bg-gray"></i>
              </li>
            </ul>
          </div>

          <div class="tab-pane" id="settings">
            <form class="form-horizontal">
              <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Name</label>

                <div class="col-sm-10">
                  <input type="email" class="form-control" id="inputName" placeholder="Name">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                <div class="col-sm-10">
                  <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                </div>
              </div>
              <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Name</label>

                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputName" placeholder="Name">
                </div>
              </div>
              <div class="form-group">
                <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                <div class="col-sm-10">
                  <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-danger">Submit</button>
                </div>
              </div>
            </form>
          </div>
        -->
        </div>
      </div>
    </div>

  </div>

@stop
