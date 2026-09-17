<?php
    // all of us
    require_once "classes/Booking.php";
    require_once "classes/CreditCardPayment.php";
    require_once "classes/FitnessClass.php";
    require_once "classes/Member.php";
    require_once "classes/PayPalPayment.php";
    require_once "classes/Payment.php";
    require_once "classes/Trainer.php";


        function showBookingResult(Booking $booking): void{
            $class = $booking->getFitnessClass();
            $status = $booking->getBookingStatus();

            echo $booking->getMember()->viewProfile() . "\n";
            echo $class->getClassName() . ": $status, spots left: ". $class->getAvailableSpots() . "\n";
        }

        echo "Test Case 1: Normal Booking Workflow\n";
        $jordan = new Member("Jordan Miles", "jordan@fitness.test");
        $priya = new Member("Priya Shah", "priya@fitness.test");
        $luis = new Member("Luis Rivera", "luis@fitness.test");
        $aisha = new Trainer("Aisha Khan", "aisha@fitness.test");
        $marcus = new Trainer("Marcus Lee", "marcus@fitness.test");

        $beginnerYoga = new FitnessClass("Beginner Yoga", $aisha, 18.00, 3);
        $strengthFundamentals = new FitnessClass("Strength Fundamentals", $marcus, 25.00, 2);
        $hiitExpress = new FitnessClass("HIIT Express", $marcus, 22.50, 4);

        $jordanBooking = new Booking($jordan, $beginnerYoga);
        $priyaBooking = new Booking($priya, $strengthFundamentals);
        $luisBooking = new Booking($luis, $beginnerYoga);

        $jordanBooking->confirmBooking();
        $priyaBooking->confirmBooking();
        $luisBooking->confirmBooking();

        showBookingResult($jordanBooking);
        showBookingResult($priyaBooking);
        showBookingResult($luisBooking);
        echo "Beginner Yoga final spots: " . $beginnerYoga->getAvailableSpots() . "\n";
        echo "Strength Fundamentals final spots: " . $strengthFundamentals->getAvailableSpots() . "\n";
        echo "HIIT Express final spots: " . $hiitExpress->getAvailableSpots() . "\n\n";

        echo "Test Case 2: Last Available Spot\n";
        $morningCycling = new FitnessClass("Morning Cycling", $marcus, 20.00, 1);
        $emmaBooking = new Booking(new Member("Emma Brooks", "emma@fitness.test"), $morningCycling);
        $emmaBooking->confirmBooking();
        showBookingResult($emmaBooking);
        echo "\n";

        echo "Test Case 3: Full Class\n";
        $advancedPilates = new FitnessClass("Advanced Pilates", $aisha, 30.00, 5);
        for ($spot = 0; $spot < 5; $spot++) {
            $advancedPilates->reserveSpot();
        }
        $noahBooking = new Booking(
            new Member("Noah Williams", "noah@fitness.test"), $advancedPilates);
        $noahBooking->confirmBooking();
        showBookingResult($noahBooking);
        echo "\n";

        echo "Test Case 4: Two Members Compete for One Spot\n";
        $boxingBasics = new FitnessClass("Boxing Basics", $marcus, 28.00, 1);
        $sophiaBooking = new Booking(new Member("Sophia Green", "sophia@fitness.test"), $boxingBasics);
        $ethanBooking = new Booking( new Member("Ethan White", "ethan@fitness.test"), $boxingBasics );
        $sophiaBooking->confirmBooking();
        $ethanBooking->confirmBooking();
        showBookingResult($sophiaBooking);
        showBookingResult($ethanBooking);
        echo "\n";

        echo "Test Case 5: Independent Object State\n";
        $yoga = new FitnessClass("Yoga", $aisha, 18.00, 5);
        $strength = new FitnessClass("Strength", $marcus, 25.00, 5);
        $yogaBookingOne = new Booking($jordan, $yoga);
        $yogaBookingTwo = new Booking($priya, $yoga);
        $yogaBookingOne->confirmBooking();
        $yogaBookingTwo->confirmBooking();
        echo "Yoga spots: " . $yoga->getAvailableSpots() . "\n";
        echo "Strength spots: " . $strength->getAvailableSpots() . "\n\n";

        echo "Test Case 6: Payment Polymorphism\n";
        $creditCardPayment = new CreditCardPayment(25.00, "TEST-CARD-4242");
        $payPalPayment = new PayPalPayment(25.00, "paypal-test@example.com");
        echo processAnyPayment($creditCardPayment) . "\n";
        echo processAnyPayment($payPalPayment) . "\n\n";

        echo "Test Case 7: Fill a Class to Capacity\n";
        $eveningYoga = new FitnessClass("Evening Yoga", $aisha, 15.00, 4);
        $eveningMembers = [
            new Member("Member One", "member1@fitness.test"),
            new Member("Member Two", "member2@fitness.test"),
            new Member("Member Three", "member3@fitness.test"),
            new Member("Member Four", "member4@fitness.test"),
            new Member("Member Five", "member5@fitness.test")
        ];

        foreach ($eveningMembers as $number => $member) {
            $booking = new Booking($member, $eveningYoga);
            $booking->confirmBooking();
            echo "Booking " . ($number + 1) . ": " . $booking->getBookingStatus()
                . ", spots left: " . $eveningYoga->getAvailableSpots() . "\n";
        }
        echo "\n";

        echo "Test Case 8: Decimal Price\n";
        $decimalClass = new FitnessClass("HIIT Express", $marcus, 22.50, 10);
        $decimalBooking = new Booking($luis, $decimalClass);
        $decimalBooking->confirmBooking();
        echo "Payment amount: $" . number_format($decimalBooking->getPaymentAmount(), 2) . "\n\n";

        echo "Test Case 9: Inheritance Check\n";
        echo $jordan->viewProfile() . "\n";
        echo $aisha->viewProfile() . "\n";


    ?>