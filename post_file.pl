#!/usr/bin/perl

use strict;
use warnings;

use URI::Escape qw/ uri_escape /;
use HTTP::Request;
use JSON::XS;
use Data::Dumper;
use CGI;
use File::Copy;
use File::Basename;

my $debug = 0;
#main
{
  CGIinit();
}

sub CGIinit{

  # CGIオブジェクト
  my $cgi = new CGI;
  print $cgi->header(-type=>'text/html; charset=utf-8');

  # アップロードディレクトリ
  my $updir = './tmp';

  # アップロードファイルのハンドル
  my $fh = $cgi->upload('cameraData');
  my $status = '';
  my $saveName = '';
  my $filename = '';
  my $mimetype = '';

  if(defined($fh)){
    # 一時ファイルの場所
    my $tmpPath = $cgi->tmpFileName($fh);

    # オリジナルのファイル名
    $filename = File::Basename::basename($fh);
    utf8::decode($filename);

    # MIME TYPEの取得
    $mimetype = $cgi->uploadInfo($fh)->{'Content-Type'};

    # ユニークなファイル名で保存。
    $filename =~ m{(\.[\w]+)$};
    $saveName = $updir.'/'.time().$1;

    # 保存
    File::Copy::move($tmpPath, $saveName) or &fail();
    chmod(0644, $saveName);
    close($fh);

    $status = "OK";
  }else{
    $status = "NG";
  }

  my $response = {
    status => $status,
    saveName => $saveName,
    filename => $filename,
    mimetype => $mimetype
  };
  print JSON::XS->new->utf8->encode ($response);

  exit;
}

1;
