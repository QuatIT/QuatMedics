<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Momentum</title>

<!-- Bootstrap -->
<link href="css/bootstrap-4.0.0.css" rel="stylesheet">
</head>
<body>
<div class="container" style="padding-top: 40px">
  <form>
    CLAIM No. V190207044
    <div class="card">
      <div class="card-header"> Claim Form </div>
      <div class="card-body">
        <h5>Patient</h5>
        <hr>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="surname">Surname</label>
            <input type="text" class="form-control form-control-sm" id="surname" placeholder="Surname" name="surname">
          </div>
          <div class="form-group col-md-4">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control form-control-sm" id="first_name" placeholder="First Name" name="first_name">
          </div>
          <div class="form-group col-md-4">
            <label for="other_names">Other Names</label>
            <input type="text" class="form-control form-control-sm" id="other_names" placeholder="Other Names" name="other_names">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="principal_member">Principal Member</label>
            <input type="text" class="form-control form-control-sm" id="principal_member" placeholder="Principal Member's Name" name="principal_member">
          </div>
          <div class="form-group col-md-4">
            <label for="employer">Employer</label>
            <input type="text" class="form-control form-control-sm" id="employer" placeholder="Employer's Name" name="employer">
          </div>
          <div class="form-group col-md-4">
            <label for="contact">Contact</label>
            <input type="text" class="form-control form-control-sm" id="contact" placeholder="Contact" name="contact">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="benefit_option">Benefit Option</label>
            <input type="text" class="form-control form-control-sm" id="benefit_option" placeholder="Benefit Option" name="benefit_option">
          </div>
          <div class="form-group col-md-2">
            <label for="number">Number</label>
            <input type="text" class="form-control form-control-sm" id="number" placeholder="Number" name="number">
          </div>
          <div class="form-group col-md-2">
            <label for="nhis_no">NHIS No.</label>
            <input type="text" class="form-control form-control-sm" id="nhis_no" placeholder="NHIS No.(TOP-UP MEMBERS)" name="nhis_no">
          </div>
          <div class="form-group col-md-2">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" class="form-control  form-control-sm">
              <option selected>Choose...</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
          <div class="form-group col-md-2">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" class="form-control form-control-sm" id="date_of_birth" placeholder="Date of Birth" name="date_of_birth">
          </div>
        </div>
        <h5>Service Provider</h5>
        <hr>
        <div class="form-row">
          <div class="form-group col-md-10">
            <label for="service_provider">Service Provider</label>
            <input type="text" class="form-control form-control-sm" id="service_provider" placeholder="Service Provider's Name" name="service_provider">
          </div>
          <div class="form-group col-md-2">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control  form-control-sm">
              <option selected>Choose...</option>
              <option value="in_patient">In-Patient</option>
              <option value="out_patient">Out-Patient</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-2">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="doctor" value="doctor">
              <label class="form-check-label" for="doctor">Dr.</label>
            </div>
          </div>
          <div class="form-group col-md-2">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="dental" value="dental">
              <label class="form-check-label" for="dental">Dental</label>
            </div>
          </div>
          <div class="form-group col-md-2">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="pharmacy" value="pharmacy">
              <label class="form-check-label" for="pharmacy">Parm.</label>
            </div>
          </div>
          <div class="form-group col-md-2">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="optician" value="optician">
              <label class="form-check-label" for="optician">Optician</label>
            </div>
          </div>
          <div class="form-group col-md-2">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="lab_tech" value="lab_tech">
              <label class="form-check-label" for="lab_tech">Lab Tech.</label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="diagnosis">Diagnosis / ICD Code</label>
            <textarea name="diagnosis" id="diagnosis" cols="30"  class="form-control form-control-sm"></textarea>
          </div>
        </div>
        <table class="table table-bordered table-sm">
          <tbody>
            <tr>
              <th style="text-align:center" scope="col">Tarrif Code</th>
              <th style="text-align:center" scope="col">Description</th>
              <th style="text-align:center" scope="col">MED / DEN / PHA / LAB</th>
              <th style="text-align:center" scope="col">Qty</th>
              <th style="text-align:center" scope="col">From</th>
              <th style="text-align:center" scope="col">Fee Charged</th>
            </tr>
            <tr>
              <td style="text-align:center">1</td>
              <td>...</td>
              <td style="text-align:center">&nbsp;</td>
              <td style="text-align:center">1</td>
              <td>&nbsp;</td>
              <td style="text-align:right">88.00</td>
            </tr>
            <tr>
              <td style="text-align:center">2</td>
              <td>...</td>
              <td style="text-align:center">&nbsp;</td>
              <td style="text-align:center">1</td>
              <td>&nbsp;</td>
              <td style="text-align:right">3.40</td>
            </tr>
            <tr>
              <th style="text-align: right" colspan="5" rowspan="3">Amount Due</th>
              <th style="text-align: right">91.40</th>
            </tr>
          </tbody>
        </table>
        <hr>
        <small>I certify that ...</small>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="refered_to">Refered To</label>
            <input type="text" class="form-control form-control-sm" id="refered_to" placeholder="Refered To" name="refered_to">
          </div>
          <div class="form-group col-md-5">
            <label for="remarks">Remarks</label>
            <input type="text" class="form-control form-control-sm" id="remarks" placeholder="Remarks" name="remarks">
          </div>
          <div class="form-group col-md-3">
            <label for="date">Service Provider's Signature</label>
            <input type="text" class="form-control form-control-sm" id="name" placeholder="Name" name="name">
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-3.2.1.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/popper.min.js"></script>
<script src="js/bootstrap-4.0.0.js"></script>
</body>
</html>
