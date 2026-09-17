<?php
// all of us 

// load the class files so index.php can use them
require_once "classes/Booking.php";
require_once "classes/CreditCardPayment.php";
require_once "classes/FitnessClass.php";
require_once "classes/Member.php";
require_once "classes/PayPalPayment.php";
require_once "classes/Payment.php";
require_once "classes/Trainer.php";

// this function displays the result of one booking
function showBookingResult(Booking $booking): void
{
    $class = $booking->getFitnessClass();

    echo strtolower($booking->getMember()->viewProfile()) . "<br>";
    echo strtolower($class->getClassName()) . ": "
        . strtolower($booking->getBookingStatus())
        . ", spots left: " . $class->getAvailableSpots() . "<br>";
}

// create members and trainers from the base dataset
$jordan = new Member("Jordan Miles", "jordan@fitness.test");
$priya = new Member("Priya Shah", "priya@fitness.test");
$luis = new Member("Luis Rivera", "luis@fitness.test");
$aisha = new Trainer("Aisha Khan", "aisha@fitness.test");
$marcus = new Trainer("Marcus Lee", "marcus@fitness.test");

// test case 1: create classes and confirm three bookings
echo "test case 1: normal booking workflow<br><br>";
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
echo "beginner yoga final spots: " . $beginnerYoga->getAvailableSpots() . "<br>";
echo "strength fundamentals final spots: " . $strengthFundamentals->getAvailableSpots() . "<br>";
echo "hiit express final spots: " . $hiitExpress->getAvailableSpots() . "<br><br>";

// test case 2: confirm the last available spot
echo "test case 2: last available spot<br><br>";
$morningCycling = new FitnessClass("Morning Cycling", $marcus, 20.00, 1);
$emmaBooking = new Booking(
    new Member("Emma Brooks", "emma@fitness.test"),
    $morningCycling
);
$emmaBooking->confirmBooking();
showBookingResult($emmaBooking);
echo "<br>";

// test case 3: try to book a full class
echo "test case 3: full class<br><br>";
$advancedPilates = new FitnessClass("Advanced Pilates", $aisha, 30.00, 5);

// reserve all five spots before trying another booking
for ($spot = 0; $spot < 5; $spot++) {
    $advancedPilates->reserveSpot();
}

$noahBooking = new Booking(
    new Member("Noah Williams", "noah@fitness.test"),
    $advancedPilates
);
$noahBooking->confirmBooking();
showBookingResult($noahBooking);
echo "<br>";

// test case 4: two members try to get one spot
echo "test case 4: two members compete for one spot<br><br>";
$boxingBasics = new FitnessClass("Boxing Basics", $marcus, 28.00, 1);
$sophiaBooking = new Booking(
    new Member("Sophia Green", "sophia@fitness.test"),
    $boxingBasics
);
$ethanBooking = new Booking(
    new Member("Ethan White", "ethan@fitness.test"),
    $boxingBasics
);

$sophiaBooking->confirmBooking();
$ethanBooking->confirmBooking();
showBookingResult($sophiaBooking);
showBookingResult($ethanBooking);
echo "<br>";

// test case 5: changing one class should not change another class
echo "test case 5: independent object state<br><br>";
$yoga = new FitnessClass("Yoga", $aisha, 18.00, 5);
$strength = new FitnessClass("Strength", $marcus, 25.00, 5);

$yogaBookingOne = new Booking($jordan, $yoga);
$yogaBookingTwo = new Booking($priya, $yoga);
$yogaBookingOne->confirmBooking();
$yogaBookingTwo->confirmBooking();

echo "yoga spots: " . $yoga->getAvailableSpots() . "<br>";
echo "strength spots: " . $strength->getAvailableSpots() . "<br><br>";

// test case 6: send both payment objects to the same function
echo "test case 6: payment polymorphism<br><br>";
$creditCardPayment = new CreditCardPayment(25.00, "TEST-CARD-4242");
$payPalPayment = new PayPalPayment(25.00, "paypal-test@example.com");

echo strtolower(processAnyPayment($creditCardPayment)) . "<br>";
echo strtolower(processAnyPayment($payPalPayment)) . "<br><br>";

// test case 7: make four successful bookings and one unsuccessful booking
echo "test case 7: fill a class to capacity<br><br>";
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

    echo "booking " . ($number + 1) . ": "
        . strtolower($booking->getBookingStatus())
        . ", spots left: " . $eveningYoga->getAvailableSpots() . "<br>";
}
echo "<br>";

// test case 8: make sure decimal prices stay as decimals
echo "test case 8: decimal price<br><br>";
$decimalClass = new FitnessClass("HIIT Express", $marcus, 22.50, 10);
$decimalBooking = new Booking($luis, $decimalClass);
$decimalBooking->confirmBooking();

echo "payment amount: $" . number_format($decimalBooking->getPaymentAmount(), 2) . "<br><br>";

// test case 9: member and trainer use viewProfile() from user
echo "test case 9: inheritance check<br><br>";
echo strtolower($jordan->viewProfile()) . "<br>";
echo strtolower($aisha->viewProfile()) . "<br>";

?>
