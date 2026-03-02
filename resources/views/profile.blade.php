<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Profil Saya | Soft UI</title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link id="pagestyle" href="https://demos.creative-tim.com/soft-ui-dashboard/assets/css/soft-ui-dashboard.min.css?v=1.0.3" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="main-content position-relative max-height-vh-100 h-100">
    
    <div class="container-fluid">
      <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://demos.creative-tim.com/soft-ui-dashboard/assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
        <span class="mask bg-gradient-primary opacity-6"></span>
      </div>
      
      <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
        <div class="row gx-4">
          <div class="col-auto">
            <div class="col-auto">
<div class="avatar avatar-xl position-relative">
    <img src="{{ $user->profile_photo_path ? asset($user->profile_photo_path) : asset('assets/img/default-avatar.jpg') }}" 
         id="avatar_preview" 
         class="w-100 border-radius-lg shadow-sm">
    
    <label for="file-input-profile" class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2 shadow-sm cursor-pointer">
        <i class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Foto"></i>
    </label>
</div>
</div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
                {{ $user->name ?? 'User Name' }}
              </h5>
              <p class="mb-0 font-weight-bold text-sm">
                {{ $user->profile->headline ?? 'Your Headline' }}
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
            <div class="nav-wrapper position-relative end-0">
              <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 active " data-bs-toggle="tab" href="#app-tab" role="tab">
                    <i class="fa fa-cube text-sm me-1"></i>
                    <span class="ms-1">App</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 " data-bs-toggle="tab" href="#messages-tab" role="tab">
                    <i class="fa fa-envelope text-sm me-1"></i>
                    <span class="ms-1">Messages</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 " data-bs-toggle="tab" href="#settings-tab" role="tab">
                    <i class="fa fa-cog text-sm me-1"></i>
                    <span class="ms-1">Settings</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="container-fluid py-4">
      <div class="row">
        
        <div class="col-12 col-xl-4 mb-4">
          <div class="card h-100">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-0">Platform Settings</h6>
            </div>
            <div class="card-body p-3">
              <h6 class="text-uppercase text-body text-xs font-weight-bolder">Account</h6>
              <ul class="list-group">
                <li class="list-group-item border-0 px-0">
                  <div class="form-check form-switch ps-0">
                    <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckFollower" checked>
                    <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckFollower">Email saya saat ada yang mengikuti</label>
                  </div>
                </li>
                <li class="list-group-item border-0 px-0">
                  <div class="form-check form-switch ps-0">
                    <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckPost">
                    <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckPost">Email saya saat ada yang membalas postingan</label>
                  </div>
                </li>
                <li class="list-group-item border-0 px-0">
                  <div class="form-check form-switch ps-0">
                    <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckMention" checked>
                    <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckMention">Email saya saat ada yang menyebut (mention) saya</label>
                  </div>
                </li>
              </ul>
              <h6 class="text-uppercase text-body text-xs font-weight-bolder mt-4">Aplikasi</h6>
              <ul class="list-group">
                <li class="list-group-item border-0 px-0">
                  <div class="form-check form-switch ps-0">
                    <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckProject">
                    <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckProject">Proyek dan peluncuran baru</label>
                  </div>
                </li>
                <li class="list-group-item border-0 px-0">
                  <div class="form-check form-switch ps-0">
                    <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckUpdates" checked>
                    <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckUpdates">Pembaruan produk bulanan</label>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-12 col-xl-8">
          <div class="card h-100">
            <div class="card-header pb-0 p-3">
              <div class="row">
                <div class="col-md-8 d-flex align-items-center">
                  <h6 class="mb-0">Edit Profile Information</h6>
                </div>
              </div>
            </div>
            <div class="card-body p-3">
              
              @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
                    <span class="alert-icon"><i class="fa fa-check text-white"></i></span>
                    <span class="alert-text"><strong>Sukses!</strong> Profil berhasil diperbarui.</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
              @endif

              @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                    <span class="alert-icon"><i class="fa fa-exclamation-triangle text-white"></i></span>
                    <span class="alert-text"><strong>Error!</strong> Mohon periksa kembali inputan Anda.</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
              @endif

              <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" id="file-input-profile" name="photo" accept="image/*" class="d-none" onchange="previewImage(this)">
                    </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-control-label">Full Name</label>
                      <input class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                      @error('name') <p class="text-danger text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-control-label">Email Address</label>
                      <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                      @error('email') <p class="text-danger text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                  </div>
                </div>

                <div class="row mt-3">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="form-control-label">Headline / Job Title</label>
                      <input class="form-control" type="text" name="headline" value="{{ old('headline', $user->profile->headline ?? '') }}">
                    </div>
                  </div>
                </div>

                <div class="row mt-3">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="form-control-label">About Me</label>
                      <textarea class="form-control" name="about_me" rows="4">{{ old('about_me', $user->profile->about_me ?? '') }}</textarea>
                    </div>
                  </div>
                </div>

                <div class="text-end mt-4">
                  <button type="submit" class="btn bg-gradient-primary">Simpan Perubahan</button>
                </div>
              </form>
              
            </div>
          </div>
        </div>
      </div>

      <footer class="footer pt-3">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart"></i> by Creative Tim.
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <script src="https://demos.creative-tim.com/soft-ui-dashboard/assets/js/core/bootstrap.min.js"></script>
  <script src="https://demos.creative-tim.com/soft-ui-dashboard/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="https://demos.creative-tim.com/soft-ui-dashboard/assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script>
<script>
  function previewImage(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('avatar_preview').src = e.target.result;
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
</body>

</html>