<?php 
$saveMethod = isset($_GET['method'])? $_GET['method'] : "newentity";
$object = "TUDELAENTITY:".md5("TUDELAENTITY:vonmiones". uniqid() );
?>
<?php if ($saveMethod == "updateentity"): ?>
    <script>var method = "updateentity"</script>
    <?php else: ?>
    <script>var method = "newentity"</script>
<?php endif ?>
    <div class="container">
        <form>
            <input type="hidden" name="object" value="<?php echo $object;  ?>">
            <div class="row d-lg-flex justify-content-lg-center">
                <div class="col">
                    <div style="height: 25px;background: var(--bs-gray-800);margin-bottom: 0;margin-left: -12px;"><span class="text-center d-lg-flex d-xl-flex justify-content-lg-center justify-content-xl-center" style="color: var(--bs-white);"><strong>Name</strong></span></div>
                    <div style="background: var(--bs-secondary);">
                        <div class="row d-lg-flex justify-content-lg-center" style="background: var(--bs-gray-300);margin-right: 0px;">
                            <div class="col">
                                <div class="row" style="padding: 5px;">
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><input id="lastname" class="form-control" type="text" placeholder="Last Name" /><label class="form-label" for="lastname" style="font-size: 13px;">Last Name</label></div>
                                    </div>
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><input id="firstname" class="form-control" type="text" placeholder="Last Name" /><label class="form-label" for="lastname" style="font-size: 13px;">First Name</label></div>
                                    </div>
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><input id="middlename" class="form-control" type="text" placeholder="Last Name" /><label class="form-label" for="lastname" style="font-size: 13px;">Middle Name</label></div>
                                    </div>
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><select class="form-select" id="suffix" style="padding-top: 5px;font-size: 13px;">
                                                <optgroup label="Name Suffix">
                                                    <option value="none" selected>None</option>
                                                    <option value="Sr">Sr</option>
                                                    <option value="Jr">Jr</option>
                                                    <option value="III">III</option>
                                                    <option value="IV">IV</option>
                                                    <option value="V">V</option>
                                                    <option value="VI">VI</option>
                                                    <option value="VII">VII</option>
                                                    <option value="VIII">VIII</option>
                                                    <option value="IX">IX</option>
                                                    <option value="X">X</option>
                                                </optgroup>
                                            </select></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-lg-flex justify-content-lg-center">
                <div class="col">
                    <div style="height: 25px;background: var(--bs-gray-800);margin-bottom: 0;margin-left: -12px;"><span class="text-center d-lg-flex d-xl-flex justify-content-lg-center justify-content-xl-center" style="color: var(--bs-white);"><strong>Civil Attributes</strong></span></div>
                    <div style="background: var(--bs-secondary);">
                        <div class="row d-lg-flex justify-content-lg-center" style="background: var(--bs-gray-300);margin-right: 0px;">
                            <div class="col">
                                <div class="row" style="padding: 5px;">
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><select class="form-select" id="sex" style="padding-top: 5px;font-size: 13px;">
                                                <optgroup label="Sex">
                                                    <option value="1" selected>Male</option>
                                                    <option value="0">Female</option>
                                                </optgroup>
                                            </select></div>
                                    </div>
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><select class="form-select" id="civilstatus" style="padding-top: 5px;font-size: 13px;">
                                                <optgroup label="Civil Status">
                                                    <option value="1" selected>Single</option>
                                                    <option value="2">Married</option>
                                                    <option value="3">Divorsed</option>
                                                    <option value="4">Legally Separated</option>
                                                    <option value="5">Widow</option>
                                                </optgroup>
                                            </select></div>
                                    </div>
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><select disabled="true" class="form-select" id="nationality" style="padding-top: 5px;font-size: 13px;">
                                                <optgroup label="Nationality">
                                                    <option value="0" selected>Filipino</option>
                                                    <option value="1">American</option>
                                                    <option value="2">Chinese</option>
                                                    <option value="3">Spanish</option>
                                                </optgroup>
                                            </select></div>
                                    </div>
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><select disabled="true"  class="form-select" id="ethnicgroup" style="padding-top: 5px;font-size: 13px;">
                                                <optgroup label="Ethnic Group">
                                                    <option value="0" selected>None</option>
                                                    <option value="1">Subanen/Subanon - Kolibugan</option>
                                                    <option value="2">Tagbanua</option>
                                                </optgroup>
                                            </select></div>
                                    </div>
                                </div>
                                <div class="row" style="padding: 5px;">
                                    <div class="col" style="padding: 1px;">
                                        <div class="form-floating mb-3" style="margin: 0px;margin-top: 5px;">
                                            <div class="form-check"><input id="withchildren" class="form-check-input" type="checkbox" /><label class="form-check-label" for="formCheck-3" style="margin-left: 10px;font-size: 13px;">with Child or Children</label></div>
                                        </div>
                                    </div>
                                    <div class="col" style="padding: 1px;font-size: 13px;">
                                        <div class="form-floating mb-3" style="margin: 0px;margin-top: 5px;font-size: 13px;">
                                            <div class="form-check" style="font-size: 13px;"><input id="ispwd" class="form-check-input" type="checkbox" style="font-size: 13px;" /><label class="form-check-label" for="formCheck-1" style="margin-left: 10px;font-size: 13px;">Person with Disability (PWD)</label></div>
                                        </div>
                                    </div>
                                    <div class="col" style="padding: 1px;font-size: 13px;">
                                        <div class="form-floating mb-3" style="margin: 0px;margin-top: 5px;font-size: 13px;">
                                            <div class="form-check" style="font-size: 13px;"><input id="idmulticitizenship" class="form-check-input" type="checkbox" style="font-size: 13px;" /><label class="form-check-label" for="formCheck-2" style="margin-left: 10px;font-size: 13px;">Has Multiple Citizenship</label></div>
                                        </div>
                                    </div>
                                    <div class="col" style="padding: 1px;font-size: 13px;">
                                        <div class="form-floating mb-3" style="margin: 0px;margin-top: 5px;font-size: 13px;">
                                            <div class="form-check" style="font-size: 13px;"><input id="isipmember" class="form-check-input" type="checkbox" style="font-size: 13px;" /><label class="form-check-label" for="formCheck-6" style="margin-left: 10px;font-size: 13px;">Indigenous Member (IPs)</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-lg-flex justify-content-lg-center">
                <div class="col">
                    <div style="height: 25px;background: var(--bs-gray-800);margin-bottom: 0;margin-left: -12px;"><span class="text-center d-lg-flex d-xl-flex justify-content-lg-center justify-content-xl-center" style="color: var(--bs-white);"><strong>Birth Details</strong></span></div>
                    <div style="background: var(--bs-secondary);">
                        <div class="row d-lg-flex justify-content-lg-center" style="background: var(--bs-gray-300);margin-right: 0px;">
                            <div class="col">
                                <div class="row" style="padding: 5px;">
                                    <div class="col" style="padding: 1px;height: 61px;max-width: 250px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><input class="form-control" id="birthdate" type="date" style="font-size: 13px;" /><label class="form-label" for="lastname">Birth Date</label></div>
                                    </div>
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><input class="form-control" id="address" type="search" /><label class="form-label" for="lastname">Address Search</label></div>
                                    </div>
                                </div>
                                <div class="row" style="padding: 5px;">
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><input id="addresslotblock" class="form-control" type="text" placeholder="Last Name" /><label class="form-label" for="lastname" style="font-size: 13px;">House, Lot, Block</label></div>
                                    </div>
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><input id="addresssubdivision" class="form-control" type="text" placeholder="Last Name" /><label class="form-label" for="lastname" style="font-size: 13px;">Subdivision</label></div>
                                    </div>
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><input id="addresspurok" class="form-control" type="text" placeholder="Last Name" /><label class="form-label" for="lastname" style="font-size: 13px;">Purok</label></div>
                                    </div>
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><input id="addressbarangay" class="form-control" type="text" placeholder="Last Name" /><label class="form-label" for="lastname" style="font-size: 13px;">Barangay</label></div>
                                    </div>
                                </div>
                                <div class="row" style="padding: 5px;">
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><input id="addresscitymun" class="form-control" type="text" placeholder="Last Name" /><label class="form-label" for="lastname" style="font-size: 13px;">City or Municipality</label></div>
                                    </div>
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><input id="addressprovince" class="form-control" type="text" placeholder="Last Name" /><label class="form-label" for="lastname" style="font-size: 13px;">Province</label></div>
                                    </div>
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><input id="addressdistrict" class="form-control" type="text" placeholder="Last Name" /><label class="form-label" for="lastname" style="font-size: 13px;">District</label></div>
                                    </div>
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><input id="addressregion" class="form-control" type="text" placeholder="Last Name" /><label class="form-label" for="lastname" style="font-size: 13px;">Region</label></div>
                                    </div>
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><input id="addresszipcode" class="form-control" type="text" placeholder="Last Name" /><label class="form-label" for="lastname" style="font-size: 13px;">Zip Code</label></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-lg-flex justify-content-lg-center">
                <div class="col">
                    <div style="height: 25px;background: var(--bs-gray-800);margin-bottom: 0;margin-left: -12px;"><span class="text-center d-lg-flex d-xl-flex justify-content-lg-center justify-content-xl-center" style="color: var(--bs-white);"><strong>Physical Attributes</strong></span></div>
                    <div style="background: var(--bs-secondary);">
                        <div class="row d-lg-flex justify-content-lg-center" style="background: var(--bs-gray-300);margin-right: 0px;">
                            <div class="col">
                                <div class="row" style="padding: 5px;">
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><select id="bloodtype" class="form-select" style="padding-top: 5px;font-size: 13px;">
                                                <optgroup label="Blood Type">
                                                    <option value="O+" selected>O+</option>
                                                    <option value="A+">A+</option>
                                                    <option value="B+">B+</option>
                                                    <option value="AB+">AB+</option>
                                                    <option value="O-">O-</option>
                                                    <option value="A-">A-</option>
                                                    <option value="B-">B-</option>
                                                    <option value="AB-">AB-</option>
                                                </optgroup>
                                            </select></div>
                                    </div>
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><input id="height" class="form-control" type="text" placeholder="Last Name" /><label class="form-label" for="lastname" style="font-size: 13px;">Height (m)</label></div>
                                    </div>
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><input id="weight" class="form-control" type="text" placeholder="Last Name" /><label class="form-label" for="lastname" style="font-size: 13px;">Weight (kg)</label></div>
                                    </div>
                                    <div class="col" style="padding: 1px;height: 61px;">
                                        <div class="form-floating mb-3" style="margin: 0px;"><input id="otherphysical" class="form-control" type="text" placeholder="Last Name" /><label class="form-label" for="lastname" style="font-size: 13px;">Other Physical Attributes</label></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>