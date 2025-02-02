@extends('layouts.app')
@section('content')

<div class="container">
<?php
$usuario_dto = Session::get('usuario_dto');
?>
      @if($usuario_dto->cuentaConRolDe('SYSADMIN'))
        <form action="{{ route('VerRegistroNoticia') }}" method="get">
          @csrf
          <button type="submit" class="btn btn-primary align-right">Nuevo</button>
        </form>
      @endif
  <!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }
      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
  </head>
  <body>
  <div class="row g-5">
    <div class="col-md-8">
      <h3 class="pb-4 mb-4 fst-italic border-bottom">
        Ultimas Noticias
      </h3>
        @foreach($lista_noticias as $noticia)
            <article class="blog-post"  id="{{ Carbon\Carbon::parse($noticia->fecha_publicacion)->format(' M ') }}">
              <div class="col-md-9">
                <h2 class="blog-post-title">{{ $noticia->titulo  }}</h2>
              </div>
              <div class="p-5 col-md-3">
                @if($usuario_dto->cuentaConRolDe('SYSADMIN'))
                  <form action="{{ route('EliminarNoticia') }}" method="get">
                    @csrf
                    <input type="hidden" name="noticia" VALUE="{{$noticia->id}}">
                    <button type="submit" class="btn btn-primary align-left">Eliminar</button>
                  </form>
                @endif
              </div>
              <p class="blog-post-meta" >{{  Carbon\Carbon::parse(strtotime($noticia->fecha_publicacion))->formatLocalized('%d %B %Y')  }} publicado: <a href="#">{{ $noticia->autor_pub->primer_nombre." ".$noticia->autor_pub->apellido_paterno  }}</a></p>
              <p>{{ $noticia->resumen}}</p>
              <hr>
              <p>{{ $noticia->cuerpo}}</p>
              <form  method="POST" action="{{ route('ComentarNoticia') }}">
                @csrf
                <input type="hidden" name="noticia" VALUE="{{$noticia->id}}">
                <div class="col-md-9">
                  <input id="ipt_comentario" type="text" class="form-control " name="comentario" value="{{ old('comentario') }}" placeholder="Escribe tu comentario..." >
                </div>
                <div class="col-md-3">
                  <input type="submit" class="btn btn-primary" value="Comentar">
                </div>
                <div class="p-2 col-md-12">
                </div>
              </form>
              <div class="card p-3">
                  @foreach($noticia->comments_pub as $comentario)
                      <div class="d-flex justify-content-between align-items-center" >
                        <div class="user d-flex flex-row align-items-center">
                           <img src="{{asset('images/comunity.jpg')}}" width="30" class="user-img rounded-circle mr-2">
                            <span><small class="font-weight-bold text-primary">{{$comentario->autor->primer_nombre ." ".$comentario->autor->apellido_paterno}}</small>
                           <small class="font-weight-bold">{{$comentario->comentario}}</small></span> </div>
                           <small>{{Carbon\Carbon::parse(strtotime($comentario->created_at))->formatLocalized('%d de %B del %Y %H:%M:%S')}} </small>
                      </div>
                      <div class="action d-flex justify-content-between mt-2 align-items-center">
                        @if($usuario_dto->roles()->pluck('uuid_usuario_rol')->first()==$comentario->autor_comentario_uuid)
                          <div class="reply px-4">
                            <form  method="POST" action="{{ route('EliminarComentario') }}">
                              @csrf
                              <input type="hidden" name="noticia" value="{{ $noticia->id }}">
                              <input type="hidden" name="uuid_comentario" VALUE="{{ $comentario->comentario_uuid }}">
                              <input type="hidden" name="autor" VALUE="{{ $comentario->autor_comentario_uuid }}">
                              <input type="hidden" name="comentario" VALUE="{{ $comentario->comentario }}">
                              <button class="col-md-6 btn" type="submit">{{ __('Eliminar') }}</button>
                            </form>
                          </div>
                        @endif

                      </div>

                @endforeach
            </article>
        @endforeach
            <div class="p-3">
              {{$lista_noticias->links()}}
            </div>
            <div class=p-3>
            </div>
            </div>

    <div class="col-md-4">
      <div class="position-sticky" style="top: 2rem;">
        <div class="p-4 mb-3 bg-light rounded">
          <h4 class="fst-italic">Comunidad</h4>
          <p class="mb-0">Intranet desarrollada para dar comunicados, y facilitar la distribución
            de información general a todo el personal miembro de la empresa(s).
          </p>
        </div>

        <div class="p-4">
          <h4 class="fst-italic">Publicaciones</h4>
          <ol class="list-unstyled mb-0">
            <li><a href="{{ route('VerNoticiasMes','01')}}">Enero 2021</a></li>
            <li><a href="{{ route('VerNoticiasMes','02')}}">Febrero 2021</a></li>
            <li><a href="{{ route('VerNoticiasMes','03')}}">Marzo 2021</a></li>
            <li><a href="{{ route('VerNoticiasMes','04')}}">Abril 2021</a></li>
            <li><a href="{{ route('VerNoticiasMes','05')}}">Mayo 2021</a></li>
            <li><a href="{{ route('VerNoticiasMes','06')}}">Junio 2021</a></li>
            <li><a href="{{ route('VerNoticiasMes','07')}}">Julio 2021</a></li>
            <li><a href="{{ route('VerNoticiasMes','08')}}">Agosto 2021</a></li>
            <li><a href="{{ route('VerNoticiasMes','09')}}">Septiembre 2021</a></li>
            <li><a href="{{ route('VerNoticiasMes','10')}}">Octubre 2021</a></li>
            <li><a href="{{ route('VerNoticiasMes','11')}}">Noviembre 2021</a></li>
            <li><a href="{{ route('VerNoticiasMes','12')}}">Diciembre 2021</a></li>
          </ol>
        </div>

        <div class="p-4">
          <h4 class="fst-italic">Otras Secciones</h4>
          <ol class="list-unstyled">
            <li><button class="btn" type="button" onclick= "location.href='{{ route('Cumpleanios')}}'"><i class="fas fa-birthday-cake"></i> Cumpleaños</button></li>
            <li><button class="btn" type="button" onclick= "location.href='{{ route('Calendario')}}'"><i class="far fa-calendar"></i> Calendario</button></li>
            <li><button class="btn" type="button" onclick= "location.href='{{ route('Eventos')}}'"><i class="far fa-star"></i> Eventos</button></li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  </body>
  </html>
</div>
</div>
@endsection
