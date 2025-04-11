<?php
if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
?>
<div id="toaster" style=" position: fixed;
    bottom: 20px;
    left: 43%;
    background-color: #fff;
    color: #fff;
    padding: 15px;
    border-radius: 5px;
    display: none;
    z-index: 9999;" class="toaster"></div>

<script>
    // Function to display toaster notification
    function showToast(message, type) {
        var toaster = document.getElementById('toaster');
        toaster.textContent = message;
        toaster.style.display = 'block';

        // Set color based on type
        if (type === 'success') {
            toaster.style.backgroundColor = '#28a745'; // Green color for success
        } else if (type === 'error') {
            toaster.style.backgroundColor = '#dc3545'; // Red color for error
        }

        // Hide toaster after 3 seconds
        setTimeout(function() {
            toaster.style.display = 'none';
        }, 10000);
    }

    // Check for success message
    <?php if (isset($_SESSION['success_message'])) { ?>
        showToast("<?php echo $_SESSION['success_message']; ?>", 'success');
        <?php unset($_SESSION['success_message']); // Clear the session variable after displaying 
        ?>
    <?php } ?>

    // Check for error message
    <?php if (isset($_SESSION['error_message'])) { ?>
        showToast("<?php echo $_SESSION['error_message']; ?>", 'error');
        <?php unset($_SESSION['error_message']); // Clear the session variable after displaying 
        ?>
    <?php } ?>
</script>