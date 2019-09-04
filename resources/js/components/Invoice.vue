<template>
    <div>
        <div id="invoice">
            <div class="toolbar hidden-print">
                <div class="text-left">
                    <button id="printInvoice" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
                    <button class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export as PDF</button>
                </div>
                <hr>
            </div>
            <div class="invoice overflow-auto">
                <div style="min-width: 600px">
                    <header>
                        <div class="row">
                            <div class="col">
                                <a target="_blank" href="https://lobianijs.com">
                                    <img src="/public/images/logo.png" data-holder-rendered="true" />
                                </a>
                            </div>
                            <div class="col company-details">
                                <h2 class="name">
                                    <a target="_blank" href="https://lobianijs.com">
                                        At Home Care
                                    </a>
                                </h2>
                                <div>{{ settings.phone }}</div>
                                <div>{{ settings.facebook }}</div>
                                <div>{{ settings.twitter }}</div>
                            </div>
                        </div>
                    </header>
                    <main>
                        <div class="row contacts">
                            <div class="col invoice-to">
                                <div class="text-gray-light">فاتورة ل :</div>
                                <h2 class="to">{{ hospital.name_ar }}</h2>
                                <div class="address">{{ hospital.address }}</div>
                                <div class="email"><a :href="'mailto:' + hospital.email">{{ hospital.email }}</a></div>
                            </div>
                            <div class="col invoice-details">
                                <h1 class="invoice-id">فاتورة رقم {{ invoice.id }}</h1>
                                <div class="date">تاريخ إنشاء الفاتورة: {{ invoice.created_at }}</div>
                                <div class="date">تاريخ دفع الفاتورة: لم يتم الدفع بعد</div>
                            </div>
                        </div>
                        <table border="0" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-left">إسم الحجز</th>
                                    <th class="text-left">السعر</th>
                                    <th class="text-left">العمولة</th>
                                    <th class="text-left">الإجمالى</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in items" v-bind:key="item.id">
                                    <td class="no">{{ item.id }}</td>
                                    <td class="text-left"><h3>doctor</h3>{{ item.order }}</td>
                                    <td class="unit">{{ item.cost }}</td>
                                    <td class="qty">20</td>
                                    <td class="total">{{ item.cost }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">SUBTOTAL</td>
                                    <td>$5,200.00</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">TAX 25%</td>
                                    <td>$1,300.00</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">GRAND TOTAL</td>
                                    <td>$6,500.00</td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="thanks">Thank you!</div>
                        <div class="notices">
                            <div>NOTICE:</div>
                            <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
                        </div>
                    </main>
                    <footer>
                        Invoice was created on a computer and is valid without the signature and seal.
                    </footer>
                </div>
                <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                <div></div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
  data() {
    return {
      hospital: [],  
      items: [],
      settings: [],
      invoice: [],
    };
  },
  props: ['hospital_id'],
  created() {
    this.fetchItems();
  },
  methods: {
    fetchItems(page_url) { 
      page_url = page_url || `../api/getinvoice/${this.hospital_id}`;
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.items = res.items;
          this.hospital = res.invoice.hospital;
          this.settings = res.settings;
          this.invoice = res.invoice;
        })
        .catch(err => console.log(err));
    },
    
  }
};
</script>