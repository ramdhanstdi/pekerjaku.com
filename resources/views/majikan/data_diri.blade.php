@extends('tamplate.majikan')

@section('content')
    <section class="data diri">
      <div class="container">
        <h2 class="my-2">Data Diri</h2>
        <div class="row mb-5">
          <div class="col">
            <img src="{{Storage::url(auth()->user()->image)}}" width="250" alt="">
          </div>
          <div class="col-9 p-2">
            <form action="{{ route('majikan.save') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row">
                  <div class="form-group col">
                    <label for="first-name">First Name</label>
                    <input class="form-control" type="text" name="first_name" id="first-name" placeholder="Enter your first name" required value="{{ $dataDiri->first_name ?? '' }}"/>
                  </div>
                  <div class="form-group col">
                    <label for="last-name">Last Name</label>
                    <input class="form-control" type="text" name="last_name" id="last-name" placeholder="Enter your last name" required value="{{ $dataDiri->last_name ?? '' }}"/>
                  </div>
              </div>
              <div class="form-group">
                  <label for="register-email">Email</label>
                  <input class="form-control" type="email" name="email" id="register-email" placeholder="Enter your email" required value="{{ $dataDiri->email ?? '' }}"/>
              </div>
              <div class="form-group">
                  <label for="address">Address</label>
                  <textarea class="form-control" name="address" id="address" placeholder="Create a address" cols="30" rows="3" >{{ $dataDiri->address ?? '' }}</textarea>
              </div>
              <div class="form-group">
                  <label for="register-password">District</label>
                  <input class="form-control" type="text" name="district" id="register-district" placeholder="Create a district" required value="{{ $dataDiri->district ?? '' }}"/>
              </div>
              <div class="form-group">
                  <label for="register-password">City</label>
                  <input class="form-control" type="text" name="regency_city" id="register-city" placeholder="Create a city" required value="{{ $dataDiri->regency_city ?? '' }}"/>
              </div>
              <div class="form-group">
                  <label for="register-password">Province</label>
                  <input class="form-control" type="text" name="province" id="register-province" placeholder="Create a province" required value="{{ $dataDiri->province ?? '' }}"/>
              </div>
              <div class="form-group">
                  <label for="postal_code">Postal Code</label>
                  <input class="form-control" type="text" name="postal_code" id="postal_code" placeholder="Create a postal code" required value="{{ $dataDiri->postal_code ?? '' }}"/>
              </div>
              <div class="form-group">
                  <label for="register-password">Phone Number</label>
                  <input class="form-control" type="text" name="phone_number" id="register-phone" placeholder="Create a phone number" required value="{{ $dataDiri->phone_number ?? '' }}"/>
              </div>
              <div class="form-group">
                  <label for="register-password">WhatsApp Number</label>
                  <input class="form-control" type="text" name="number_whatsapp" id="register-whatsaapp" placeholder="Create a phone number" required value="{{ $dataDiri->number_whatsapp ?? '' }}"/>
              </div>
              <div class="form-group">
                  <label for="register-password">Photo</label>
                  <input class="form-control" type="file" name="image" id="register-whatsaapp" placeholder="Create a phone number" />
              </div>
              <div class="form-group">
                  <label  name="ktp" for="register-password">KTP</label>
                  <input class="form-control" type="file" name="ktp" id="register-whatsaapp" placeholder="Create a phone number" >
              </div>
              <div class="form-group">
                  <label name="selfiektp" for="register-password">Selfie KTP</label>
                  <input class="form-control" type="file" name="selfiektp" id="register-whatsaapp" placeholder="Create a phone number" >
              </div>
              <div class="actions">
                  <button type="submit" class="btn btn-primary btn-md">Save</button>
              </div>
          </form>
        </div>
      </div>
    </section>
@endsection