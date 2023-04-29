<?php 
include 'registry.controller.php';
$ir = new RegistryModel();
R::selectDatabase('SOCIALENTITY');
?>

<style>

a {
  cursor: pointer;
}
.editor
{
    position:relative;
}
.editorAria {
  height:100%;
  min-height:100px;
  border:1px solid #ddd;
  overflow-y: auto;
  padding: 1em;
  margin-top: -2px;
  outline: none;
}

.toolbar {
    position:sticky;
    top:0;
    left:0;
    right:0;
    background-color:#fff;
    border:1px solid #ddd;
    padding:10px;
}

.toolbar a,
.fore-wrapper,
.back-wrapper {
  border: 1px solid #ddd;
  background: #FFF;
  color: #000;
  padding: 5px;
    margin: 2px 0px;
  width:35px;
    height:35px;
  display: inline-block;
    text-align:center;
  text-decoration: none;
}

.toolbar a:hover,
.fore-wrapper:hover,
.back-wrapper:hover {
  background: #0eacc6;
  color:#fff;
  border-color:#0eacc6;
}

a.palette-item {
    display:inline-block;
  height: 1.3em;
  width: 1.3em;
  margin: 0px 1px 1px;
    cursor:pointer;
}
a.palette-item[data-value="#FFFFFF"]{
    border:1px solid #ddd!important;
}
a.palette-item:hover {
  transform:scale(1.1);
}
.fore-wrapper,
.back-wrapper
{
    position:relative;
    cursor:auto;
}
.fore-palette,
.back-palette {
  display: none;
    cursor:auto;
}

.fore-wrapper:hover .fore-palette,
.back-wrapper:hover .back-palette {
    display:block;
}

.fore-wrapper .fore-palette,
.back-wrapper .back-palette {
    position:relative;
  display: inline-block;
  cursor: auto;
  display: block;
    left:0;
    top:calc(100% + 5px);
  position: absolute;
  padding: 10px 5px;
  width: 160px;
  background: #FFF;
  box-shadow: 0 0 5px #CCC;
    display:none;
    text-align:left;
}
.fore-wrapper .fore-palette:after,
.back-wrapper .back-palette:before
{
    content:'';
    display:inline-block;
    position:absolute;
    top:-10px;
    left:10px;
    width:0;
    height:0;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-bottom: 10px solid #fff;
}
.fore-palette a,
.back-palette a {
  background: #FFF;
  margin-bottom: 2px;
    border:none;
}
.editor img
{
    max-width:100%;
    object-fit:cover;
}
.optionupper{
  text-transform: uppercase;
}

option:checked:before {
  content: '✓';
  padding-left:5px;
  padding-right:15px;
  transition-timing-function: ease-in;
  transition: 0.3s;
}
</style>
<section class="contact-clean">
  <div class="container">
      <div class="row">
          <div class="col-4">
            <?php 
            $requestorid = "";
            $order_code = "";
            $categoryid = "";
            $metadata = "";
            $isparent = "";
            $parentid = "";
             ?>
            <select id="subcategories" multiple  name="subcategories[]" style="width:100%;height:100%; padding:10px;">
                <?php foreach ($ir->GetCategories() as $category): ?>
                  <optgroup label="<?php echo $category['category_name']; ?>">
                      <?php foreach ($ir->GetSubCategories($category["id"]) as $subcat): ?>
                        <option value="<?php echo $subcat["subcat_code"] ?>"><?php echo $subcat["subcat_name"]; ?></option>
                      <?php endforeach ?>
                  </optgroup>
                <?php endforeach ?>
                
            </select>
          </div>
          <div class="col">
              <div class="row">
                  <div class="col">
                    <div class="mb-3">
                      <label for="fileattachment" class="form-label">Attach file <span style="font-size: x-small;"> (Screenshot, sample document, or any file that will support your request.  )</span> </label>
                      <input class="form-control" name="fileattachment[]"  type="file" id="fileattachment">
                    </div>
                    <div class="form-floating mb-3" style="margin: 0px;">
                      Request Details
                      <textarea id="joborder" class="form-control" style="width: 100%;padding: 10px;height: 400px;"></textarea>
                    </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>


