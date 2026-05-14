<!-- MODAL REZERWACJI 1-->
    <div class="modal fade" id="bookModal1" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content bg-dark text-light border border-secondary">
                <div class="modal-header border-secondary">
                    <h4 class="modal-title">Zarezerwuj stolik [1/3]</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <!-- FORMULARZ REZERWACJI 1-->
                <form action="<?=BOOK?>" method="POST">
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="range" class="form-range" min="1" max="8" value="4" id="guestNum" name="guestNum">
                            <output for="range4" id="rangeValue" aria-hidden="true"></output>
                            <input type="hidden" name="bookPage" value="1">
                        </div>                            
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="submit" class="btn btn-success">Dalej</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    </div>
                </form>
            </div>
        </div>
    </div>  
    
<!-- MODAL REZERWACJI 2-->
    <div class="modal fade" id="bookModal2" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content bg-dark text-light border border-secondary">
                <div class="modal-header border-secondary">
                    <h4 class="modal-title">Zarezerwuj stolik [2/3]</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <!-- FORMULARZ REZERWACJI 2-->
                <form action="<?=BOOK?>" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tableNum">
                                <p>Wybierz numer stolika.</p>
                                <select class="form-select bg-dark text-white" name="tableNum" id="tableNum">
                                    <?php
                                        $stmt = mysqli_prepare($conn, "SELECT id,numerStolika FROM stoliki WHERE liczbaMiejsc = ? and zarezerwowany = 0;");
                                        mysqli_stmt_bind_param($stmt, "i", $_SESSION['book_guest_number']);
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);
                                        while($row = mysqli_fetch_assoc($result)){
                                            echo "<option class='text-light' value='{$row['id']}'>".htmlspecialchars($row['numerStolika'])."</option>";
                                        }
                                    ?>
                                    <input type="hidden" name="bookPage" value="2">
                                </select>
                            </label>
                        </div>                         
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="submit" class="btn btn-success">Dalej</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    </div>
                </form>
            </div>
        </div>
    </div>    

<!-- MODAL REZERWACJI 3-->
    <div class="modal fade" id="bookModal3" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content bg-dark text-light border border-secondary">
                <div class="modal-header border-secondary">
                    <h4 class="modal-title">Zarezerwuj stolik [3/3]</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <!-- FORMULARZ REZERWACJI 3-->
                <form action="<?=BOOK?>" method="POST">
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="date" name="bookDate" placeholder="" id="bookDate" class="form-control bg-dark text-light border-secondary">
                            <label for="bookDate" class="text-secondary">Wybierz dzień rezerwacji.</label>                        
                            <input type="hidden" name="bookPage" value="3">
                        </div>
                        <div class="mb-3">
                            <label for="bookTime">
                                <p>Wybierz godzinę rezerwacji.</p>
                                <select class="form-select bg-dark text-white" name="bookTime" id="bookTime">
                                    <?php
                                        for($i=2; $i<=7; $i++){
                                            echo "<option class='text-light' value='1{$i}'>1{$i}:00</option>";
                                        }
                                    ?>
                                </select>
                                    <input type="hidden" name="bookPage" value="3">
                            </label>
                        </div>                                                   
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="submit" class="btn btn-success">Dalej</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    </div>
                </form>
            </div>
        </div>
    </div>     

<script>
  // This is an example script, please modify as needed
  const rangeInput = document.getElementById('guestNum');
  const rangeOutput = document.getElementById('rangeValue');

  // Set initial value
  rangeOutput.textContent = "Liczba gości: "+rangeInput.value;

  rangeInput.addEventListener('input', function() {
    rangeOutput.textContent = "Liczba gości: "+this.value;
  });
</script>    