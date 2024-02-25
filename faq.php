<style>
   /* Custom styles for the deep black theme */
   body {
      background-color: #000; /* Deep black background for the entire page */
   }

   .ftco-section.ftco-faq {
      background-color: #111; /* Darker black background for the FAQ section */
      color: #fff; /* White text */
   }

   .faq-heading {
      text-align: center;
      margin-bottom: 30px;
      color: #fff; /* White color for the heading text */
   }

   .card-header {
      background-color: #333; /* Dark gray background for question headers */
   }

   .btn-link {
      color: #fff; /* White color for question text */
   }

   .card-body {
      background-color: #222; /* Slightly lighter black background for answer sections */
   }
</style>
<section class="ftco-section ftco-faq">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
         <h2 class="faq-heading">Frequently Asked Questions (FAQ)</h2>
            <div class="accordion" id="accordionExample">

               <?php
               $faqs = [
                  ["What coffee blends do you offer?", "We offer a variety of unique coffee blends, each crafted with precision to suit different preferences. You can explore our menu on the website to discover our current selection."],
                  ["How can I place an order for your coffee blends?", "Ordering is easy! Simply navigate to our menu, select your desired coffee blend, and follow the prompts to complete the order. You can customize your order based on grind size, quantity, and any additional preferences."],
                  ["Do you offer any subscription plans for regular coffee deliveries?", "Yes, we provide subscription plans for those who want a regular supply of their favorite coffee blends. Check out our subscription options on the website to enjoy the convenience of automatic deliveries."],
                  ["Can I customize the grind size of the coffee beans?", "Absolutely! When placing your order, you can specify the grind size according to your brewing method. Choose from options like whole beans, coarse, medium, or fine grind."],
                  ["What payment methods do you accept?", "We accept a variety of payment methods, including credit/debit cards and other secure online payment options. Rest assured, our payment gateway is safe and reliable."],
                  ["How can I track my order?", "Once your order is confirmed, you will receive a confirmation email with a tracking link. You can use this link to monitor the status and location of your coffee blend delivery."],
                  ["Do you offer international shipping?", "Currently, we only offer shipping within [your country/region]. We are working on expanding our shipping options, so stay tuned for updates on international delivery."],
                  ["Are there any discounts or promotions available?", "Yes, we regularly run promotions and offer discounts on our coffee blends. Keep an eye on our website and subscribe to our newsletter to stay informed about the latest deals and offers."],
                  ["Can I modify or cancel my order after placing it?", "Once an order is confirmed, modifications or cancellations may not be possible. However, please contact our customer support as soon as possible, and we'll do our best to assist you."],
                  ["How can I provide feedback or share my experience with your coffee blends?", "We value your feedback! You can leave a review on our website or reach out to our customer support team. Your input helps us improve and ensures that we continue to provide exceptional coffee blends."]
               ];

               foreach ($faqs as $index => $faq) {
               ?>
                  <div class="card">
                     <div class="card-header" id="heading<?= $index + 1 ?>">
                        <h2 class="mb-0">
                           <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?= $index + 1 ?>" aria-expanded="true" aria-controls="collapse<?= $index + 1 ?>">
                              <?= $faq[0] ?>
                           </button>
                        </h2>
                     </div>

                     <div id="collapse<?= $index + 1 ?>" class="collapse" aria-labelledby="heading<?= $index + 1 ?>" data-parent="#accordionExample">
                        <div class="card-body">
                           <?= $faq[1] ?>
                        </div>
                     </div>
                  </div>
               <?php } ?>

            </div>
         </div>
      </div>
   </div>
</section>