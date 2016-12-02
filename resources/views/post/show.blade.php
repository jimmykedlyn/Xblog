@extends('layouts.app')
@section('description',$post->description)
@section('keywords',$post->category->name)
@section('title',$post->title)
@section('css')
    <style>
        .post-info-panel {
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
            border-bottom: 1px solid #e9ecef;
            padding: 15px 20px;
            margin: 10px -10px 10px;
            color: #495057;
            font-size: 16px;
        }
        .post-info-panel .info{

        }
        .post-info-panel .info-title{
            margin-right: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div id="post-detail-wrap" class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-12 phone-no-padding">
                @can('update',$post)
                    <div class="btn-group">
                        <a class="btn" href="{{ route('post.edit',$post->id) }}"><i class="fa fa-pencil"></i></a>
                        <a class="btn" role="button"
                           data-method="delete"
                           data-url="{{ route('post.destroy',$post->id) }}"
                           data-modal-target="{{ $post->title }}">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </div>
                @endcan
                <div class="post-detail">
                    <div class="center-block">
                        <div class="post-detail-title">{{ $post->title }}</div>
                        <div class="post-meta">
                           <span class="post-time">
                           <i class="fa fa-calendar-o"></i>
                           <time datetime="{{ $post->created_at->tz('UTC')->toAtomString() }}">
                           {{ $post->published_at==null?'Un Published':$post->created_at->format('Y-m-d H:i') }}
                           </time>
                           </span>
                            <span class="post-category">
                           &nbsp;|&nbsp;
                           <i class="fa fa-folder-o"></i>
                           <a href="{{ route('category.show',$post->category->name) }}">
                           {{ $post->category->name }}
                           </a>
                           </span>
                            <span class="post-comments-count">
                           &nbsp;|&nbsp;
                           <i class="fa fa-comments-o fa-fw" aria-hidden="true"></i>
                           <span>{{ $post->comments_count }}</span>
                           </span>
                            <span>
                           &nbsp;|&nbsp;
                           <i class="fa fa-eye"></i>
                           <span>{{ $post->view_count }}</span>
                           </span>
                        </div>
                    </div>
                    <br>
                    <div class="post-detail-content">
                        {!! $post->html_content !!}
                        <br>
                        <p>
                            -- END
                        </p>
                    </div>
                    <div class="post-info-panel">
                        <p class="info">
                            <label class="info-title">版权声明:</label><i class="fa fa-fw fa-creative-commons"></i>自由转载-非商用-非衍生-保持署名（<a
                                    href="https://creativecommons.org/licenses/by-nc-nd/3.0/deed.zh">创意共享3.0许可证</a>）
                        </p>
                        <p class="info">
                            <label class="info-title">发表日期:</label>{{ $post->created_at->format('Y年m月d日') }}
                        </p>
                        <p class="info">
                            <label class="info-title">修改日期:</label>{{ $post->updated_at->format('Y年m月d日') }}
                        </p>
                        <p class="info">
                            <label class="info-title">文章标签:</label>
                            @foreach($post->tags as $tag)
                                <a class="tag" href="{{ route('tag.show',$tag->name) }}">{{ $tag->name }}</a>
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @if(!(isset($preview) && $preview) && $post->isShownComment())
            <div class="row mt-30">
                <div id="comment-wrap" class="col-md-8 col-md-offset-2 col-sm-12 phone-no-padding">
                    @include('widget.comment',[
                    'comment_key'=>$post->slug,
                    'comment_title'=>$post->title,
                    'comment_url'=>route('post.show',$post->slug),
                    'commentable'=>$post,
                    'redirect'=>request()->fullUrl(),
                     'commentable_type'=>'App\Post'])
                </div>
            </div>
        @endif
    </div>
@endsection