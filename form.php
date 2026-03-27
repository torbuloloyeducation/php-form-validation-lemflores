<?php
$nameErr = $emailErr = $genderErr = $phoneErr = $websiteErr = $passwordErr = $confirmPasswordErr = $termsErr = "";
$name = $email = $website = $comment = $gender = $phone = $password = $confirmPassword = "";
$submitted = false;
$attemptCount = isset($_POST['attempt_count']) ? (int)$_POST['attempt_count'] : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submitted = true;
    $attemptCount++; 

    if (empty($_POST["phone"])) {
        $phoneErr = "Phone number is required";
    } else {
        $phone = test_input($_POST["phone"]);
        if (!preg_match("/^[+]?[0-9 \-]{7,15}$/", $phone)) {
            $phoneErr = "Invalid phone format";
        }
    }

    if (!empty($_POST["website"])) {
        $website = test_input($_POST["website"]);
        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            $websiteErr = "Invalid URL format";
        }
}

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } elseif (strlen($_POST["password"]) < 8) {
        $passwordErr = "Password must be at least 8 characters long";
    } else {
        $password = test_input($_POST["password"]);
    }

    if (empty($_POST["confirm_password"])) {
        $confirmPasswordErr = "Please confirm your password";
    } else {
        $confirmPassword = test_input($_POST["confirm_password"]);
        if ($password !== $confirmPassword) {
            $confirmPasswordErr = "Passwords do not match";
        }
    }

    if (!isset($_POST['terms'])) {
        $termsErr = "You must agree to the terms and conditions";
    }

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    $comment = empty($_POST["comment"]) ? "" : test_input($_POST["comment"]);

    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = test_input($_POST["gender"]);
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$formValid = $submitted && empty($nameErr) && empty($emailErr) && empty($genderErr) && 
             empty($phoneErr) && empty($websiteErr) && empty($passwordErr) && 
             empty($confirmPasswordErr) && empty($termsErr);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern PHP Form - Completed Exercises</title>
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --bg-color: #f9fafb;
            --card-bg: #ffffff;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --error-red: #ef4444;
            --success-green: #10b981;
            --border-color: #e5e7eb;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .form-container {
            background: var(--card-bg);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        .field-row { margin-bottom: 20px; display: flex; flex-direction: column; }
        label { font-weight: 600; font-size: 0.875rem; margin-bottom: 6px; }
        input[type="text"], input[type="password"], textarea {
            width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px;
        }
        .error { color: var(--error-red); font-size: 0.8rem; margin-top: 4px; }
        .radio-group { display: flex; gap: 15px; margin-top: 5px; }
        .success-box { background-color: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .output-box { background-color: #f3f4f6; padding: 15px; border-radius: 8px; margin-top: 20px; }
        .attempt-tag { font-size: 0.75rem; background: #e5e7eb; padding: 2px 8px; border-radius: 10px; float: right; }
    </style>
</head>
<body>

<div class="form-container">
    <span class="attempt-tag">Submission attempt: <?= $attemptCount ?></span>
    <h2>Get in Touch</h2>
    <p style="font-size: 0.875rem; color: var(--text-muted);">Fields marked with <span style="color:var(--error-red)">*</span> are required.</p>

    <?php if ($formValid): ?>
        <div class="success-box">Form submitted successfully!</div>
    <?php endif; ?>

    <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
        <input type="hidden" name="attempt_count" value="<?= $attemptCount ?>">

        <div class="field-row">
            <label for="name">Name <span style="color:var(--error-red)">*</span></label>
            <input type="text" id="name" name="name" value="<?= $name ?>">
            <?php if($nameErr): ?><span class="error"><?= $nameErr ?></span><?php endif; ?>
        </div>

        <div class="field-row">
            <label for="email">E-mail <span style="color:var(--error-red)">*</span></label>
            <input type="text" id="email" name="email" value="<?= $email ?>">
            <?php if($emailErr): ?><span class="error"><?= $emailErr ?></span><?php endif; ?>
        </div>

        <div class="field-row">
            <label for="phone">Phone Number <span style="color:var(--error-red)">*</span></label>
            <input type="text" id="phone" name="phone" placeholder="+1 234 567 890" value="<?= $phone ?>">
            <?php if($phoneErr): ?><span class="error"><?= $phoneErr ?></span><?php endif; ?>
        </div>

        <div class="field-row">
            <label for="website">Website</label>
            <input type="text" id="website" name="website" placeholder="https://..." value="<?= $website ?>">
            <?php if($websiteErr): ?><span class="error"><?= $websiteErr ?></span><?php endif; ?>
        </div>

        <div class="field-row">
            <label for="password">Password <span style="color:var(--error-red)">*</span></label>
            <input type="password" id="password" name="password">
            <?php if($passwordErr): ?><span class="error"><?= $passwordErr ?></span><?php endif; ?>
        </div>

        <div class="field-row">
            <label for="confirm_password">Confirm Password <span style="color:var(--error-red)">*</span></label>
            <input type="password" id="confirm_password" name="confirm_password">
            <?php if($confirmPasswordErr): ?><span class="error"><?= $confirmPasswordErr ?></span><?php endif; ?>
        </div>

        <div class="field-row">
            <label>Gender <span style="color:var(--error-red)">*</span></label>
            <div class="radio-group">
                <label><input type="radio" name="gender" value="Female" <?= ($gender == "Female") ? "checked" : "" ?>> Female</label>
                <label><input type="radio" name="gender" value="Male" <?= ($gender == "Male") ? "checked" : "" ?>> Male</label>
            </div>
            <?php if($genderErr): ?><span class="error"><?= $genderErr ?></span><?php endif; ?>
        </div>

        <div class="field-row" style="flex-direction: row; align-items: center; gap: 10px;">
            <input type="checkbox" id="terms" name="terms">
            <label for="terms" style="margin: 0;">I agree to the terms and conditions <span style="color:var(--error-red)">*</span></label>
        </div>
        <?php if($termsErr): ?><div class="error" style="margin-bottom: 20px;"><?= $termsErr ?></div><?php endif; ?>

        <button type="submit" style="width:100%; background: var(--primary-color); color: white; padding: 12px; border: none; border-radius: 6px; cursor: pointer;">Send Message</button>
    </form>

    <div class="output-box">
        <?php if ($submitted && $formValid): ?>
            <h3>Your Input:</h3>
            <p><strong>Name:</strong> <?= $name ?></p>
            <p><strong>Phone:</strong> <?= $phone ?></p>
            <p><strong>E-mail:</strong> <?= $email ?></p>
            <p><strong>Gender:</strong> <?= $gender ?></p>
            <?php else: ?>
            <p style="margin:0; font-style: italic;">Complete the form to see results.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
