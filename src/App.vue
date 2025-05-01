<template>
  <div class="app-container">
    <!-- Header Section -->
    <header class="header">
      <div class="logo-container">
        <div class="logo">
          <span class="icon">👟</span>
          <h1>OhMyWash</h1>
        </div>
        <p class="tagline">Bersih, Cepat & Terpercaya</p>
      </div>
      <nav class="main-nav">
        <a href="#home" class="nav-item" :class="{ active: activeSection === 'home' }" @click.prevent="scrollToSection('home')">Beranda</a>
        <a href="#services" class="nav-item" :class="{ active: activeSection === 'services' }" @click.prevent="scrollToSection('services')">Layanan</a>
        <a href="#how-it-works" class="nav-item" :class="{ active: activeSection === 'how-it-works' }" @click.prevent="scrollToSection('how-it-works')">Cara Kerja</a>
        <a href="#testimonials" class="nav-item" :class="{ active: activeSection === 'testimonials' }" @click.prevent="scrollToSection('testimonials')">Testimonial</a>
        <a href="#order" class="nav-item" :class="{ active: activeSection === 'order' }" @click.prevent="scrollToSection('order')">Pesan</a>
      </nav>
      <div class="mobile-menu-toggle" @click="toggleMobileMenu">
        <div class="bar" v-for="i in 3" :key="i"></div>
      </div>
      <div class="mobile-menu" :class="{ 'show': showMobileMenu }">
        <a href="#home" @click="scrollToSection('home', true)">Beranda</a>
        <a href="#services" @click="scrollToSection('services', true)">Layanan</a>
        <a href="#how-it-works" @click="scrollToSection('how-it-works', true)">Cara Kerja</a>
        <a href="#testimonials" @click="scrollToSection('testimonials', true)">Testimonial</a>
        <a href="#order" @click="scrollToSection('order', true)">Pesan</a>
      </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero" ref="home">
      <div class="hero-content">
        <h2>Sepatu Bersih, Tampil Percaya Diri</h2>
        <p>Layanan cuci sepatu profesional dengan teknologi modern dan bahan premium</p>
        <button class="cta-button" @click="scrollToSection('order')">Pesan Sekarang</button>
      </div>
      <div class="hero-image">
        <div class="placeholder-image">
          <img src="/assets/ohmywash.jpeg" alt="OhMyWash Professional Shoe Cleaning Service" class="actual-image">
      </div>
      </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services" ref="services">
      <h2 class="section-title">Layanan Kami</h2>
      <div class="service-cards">
        <div 
          v-for="(service, index) in services" 
          :key="index" 
          class="service-card" 
          :class="{ 'featured': service.featured }"
          @click="selectService(service)"
        >
          <div class="service-icon">{{ service.icon }}</div>
          <h3>{{ service.name }}</h3>
          <p>{{ service.description }}</p>
          <p class="price">{{ service.price }}</p>
          <button class="order-button">Pilih</button>
        </div>
      </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="how-it-works" ref="how-it-works">
      <h2 class="section-title">Bagaimana Cara Kerja</h2>
      <div class="steps">
        <div class="step" v-for="(step, index) in steps" :key="index">
          <div class="step-number">{{ index + 1 }}</div>
          <h3>{{ step.title }}</h3>
          <p>{{ step.description }}</p>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials" ref="testimonials">
      <h2 class="section-title">Apa Kata Pelanggan Kami</h2>
      <div class="testimonial-carousel">
        <button class="carousel-btn prev" @click="prevTestimonial">❮</button>
        <div class="testimonial-cards">
          <div 
            v-for="(testimonial, index) in testimonials" 
            :key="index" 
            class="testimonial-card" 
            v-show="currentTestimonialIndex === index"
          >
            <p class="quote">"{{ testimonial.quote }}"</p>
            <div class="testimonial-author">
              <div class="avatar">👤</div>
              <div class="author-info">
                <h4>{{ testimonial.author }}</h4>
                <div class="rating">{{ '★'.repeat(testimonial.rating) }}</div>
              </div>
            </div>
          </div>
        </div>
        <button class="carousel-btn next" @click="nextTestimonial">❯</button>
      </div>
      <div class="testimonial-dots">
        <span 
          v-for="(_, index) in testimonials" 
          :key="index" 
          class="dot" 
          :class="{ active: currentTestimonialIndex === index }"
          @click="setTestimonial(index)"
        ></span>
      </div>
    </section>

    <!-- Order Form Section -->
    <section id="order" class="order-form" ref="order">
      <h2 class="section-title">Pesan Sekarang</h2>
      
      <div v-if="orderSuccess" class="order-success">
        <div class="success-icon">✅</div>
        <h3>Pesanan Berhasil!</h3>
        <p>Terima kasih {{ formData.name }}. Pesanan Anda telah diterima.</p>
        <p>Kami akan menghubungi Anda di nomor {{ formData.phone }} untuk konfirmasi.</p>
        <p>Sepatu Anda akan diambil pada tanggal {{ formatDate(formData.pickupDate) }}</p>
        <button class="cta-button" @click="orderSuccess = false">Pesan Lagi</button>
      </div>

      <form v-else class="form">
        <div class="form-row">
          <div class="form-group">
            <label for="name">Nama Lengkap <span class="required">*</span></label>
            <input 
              type="text" 
              id="name" 
              v-model="formData.name" 
              placeholder="Masukkan nama lengkap"
              :class="{ 'error': errors.name }"
            >
            <small class="error-message" v-if="errors.name">{{ errors.name }}</small>
          </div>
          <div class="form-group">
            <label for="phone">Nomor Telepon <span class="required">*</span></label>
            <input 
              type="tel" 
              id="phone" 
              v-model="formData.phone" 
              placeholder="Masukkan nomor telepon"
              :class="{ 'error': errors.phone }"
            >
            <small class="error-message" v-if="errors.phone">{{ errors.phone }}</small>
          </div>
        </div>
        
        <div class="form-row">
          <div class="form-group">
            <label for="address">Alamat Pengambilan <span class="required">*</span></label>
            <textarea 
              id="address" 
              v-model="formData.address" 
              placeholder="Masukkan alamat lengkap"
              :class="{ 'error': errors.address }"
            ></textarea>
            <small class="error-message" v-if="errors.address">{{ errors.address }}</small>
          </div>
        </div>
        
        <div class="form-row">
          <div class="form-group">
            <label for="service">Pilih Layanan <span class="required">*</span></label>
            <select 
              id="service" 
              v-model="formData.service"
              :class="{ 'error': errors.service }"
            >
              <option value="">-- Pilih Layanan --</option>
              <option 
                v-for="(service, index) in services" 
                :key="index" 
                :value="service.id"
              >
                {{ service.name }} - {{ service.price }}
              </option>
            </select>
            <small class="error-message" v-if="errors.service">{{ errors.service }}</small>
          </div>
          <div class="form-group">
            <label for="pickup-date">Tanggal Pengambilan <span class="required">*</span></label>
            <input 
              type="date" 
              id="pickup-date" 
              v-model="formData.pickupDate"
              :min="minDate"
              :class="{ 'error': errors.pickupDate }"
            >
            <small class="error-message" v-if="errors.pickupDate">{{ errors.pickupDate }}</small>
          </div>
        </div>
        
        <div class="form-row">
          <div class="form-group">
            <label for="notes">Catatan Tambahan</label>
            <textarea id="notes" v-model="formData.notes" placeholder="Jenis sepatu, warna, atau instruksi khusus"></textarea>
          </div>
        </div>
        
        <button type="submit" class="submit-button" @click.prevent="submitOrder">
          <span v-if="loading" class="loading-spinner"></span>
          <span v-else>Kirim Pesanan</span>
        </button>
      </form>
    </section>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.link/hago6d" class="whatsapp-float" target="_blank">
      <div class="whatsapp-icon">💬</div>
    </a>

    <!-- Footer -->
    <footer class="footer">
      <div class="footer-content">
        <div class="footer-logo">
          <span class="icon">👟</span>
          <h3>OhMyWash</h3>
        </div>
        <div class="footer-contact">
          <p><strong>Alamat:</strong> Jl. Sepatu Indah No. 123, Surabaya</p>
          <p><strong>Telepon:</strong> 021-1234567</p>
          <p><strong>Email:</strong> @OhMyWash.instagram</p>
        </div>
        <div class="footer-hours">
          <h4>Jam Operasional</h4>
          <p>Senin - Jumat: 08.00 - 20.00</p>
          <p>Sabtu - Minggu: 10.00 - 18.00</p>
        </div>
        <div class="footer-social">
          <h4>Ikuti Kami</h4>
          <div class="social-icons">
            <a href="#" class="social-icon">📱</a>
            <a href="#" class="social-icon">📷</a>
            <a href="#" class="social-icon">💬</a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; {{ currentYear }} OhMyWash. Semua hak dilindungi.</p>
      </div>
    </footer>

    <!-- Modal for service details -->
    <div class="modal" v-if="showServiceModal">
      <div class="modal-content">
        <span class="close-button" @click="closeServiceModal">&times;</span>
        <div v-if="selectedService" class="service-details">
          <div class="service-header">
            <div class="service-icon large">{{ selectedService.icon }}</div>
            <h2>{{ selectedService.name }}</h2>
          </div>
          <p class="price large">{{ selectedService.price }}</p>
          <div class="service-description">
            <p>{{ selectedService.fullDescription }}</p>
          </div>
          <div class="service-features">
            <h3>Fitur Layanan:</h3>
            <ul>
              <li v-for="(feature, index) in selectedService.features" :key="index">
                {{ feature }}
              </li>
            </ul>
          </div>
          <div class="service-duration">
            <h3>Estimasi Waktu:</h3>
            <p>{{ selectedService.duration }}</p>
          </div>
          <button class="cta-button" @click="orderSelectedService">Pesan Layanan Ini</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      activeSection: 'home',
      showMobileMenu: false,
      currentTestimonialIndex: 0,
      orderSuccess: false,
      loading: false,
      showServiceModal: false,
      selectedService: null,
      
      // Form data
      formData: {
        name: '',
        phone: '',
        address: '',
        service: '',
        pickupDate: '',
        notes: ''
      },
      
      // Form validation errors
      errors: {
        name: '',
        phone: '',
        address: '',
        service: '',
        pickupDate: ''
      },
      
      // Services data
      services: [
        {
          id: 'standard',
          name: 'Cuci Standar',
          icon: '🧼',
          description: 'Pembersihan menyeluruh menggunakan bahan premium',
          fullDescription: 'Layanan cuci standar menjamin sepatu Anda bersih dan terawat. Paket ini mencakup pembersihan seluruh bagian luar sepatu, penghilangan noda ringan, dan perawatan bahan.',
          price: 'Rp 35.000',
          features: [
            'Pembersihan bagian luar sepatu',
            'Penghilangan noda ringan',
            'Pembersihan tali sepatu',
            'Pengeringan dengan teknologi khusus'
          ],
          duration: '1-2 hari kerja',
          featured: false
        },
        {
          id: 'deep',
          name: 'Deep Clean',
          icon: '✨',
          description: 'Pembersihan mendalam termasuk sol dan bagian dalam',
          fullDescription: 'Deep Clean adalah solusi terbaik untuk sepatu yang butuh perhatian ekstra. Layanan ini mencakup pembersihan mendalam pada seluruh bagian sepatu termasuk bagian dalam, sol, dan penanganan noda membandel.',
          price: 'Rp 55.000',
          features: [
            'Pembersihan bagian luar dan dalam sepatu',
            'Penghilangan noda membandel',
            'Pembersihan sol dan insole',
            'Sanitasi dan penghilangan bau',
            'Perawatan bahan khusus',
            'Pengeringan dengan teknologi khusus'
          ],
          duration: '2-3 hari kerja',
          featured: true
        },
        {
          id: 'repaint',
          name: 'Repaint',
          icon: '🔄',
          description: 'Pewarnaan ulang sepatu agar tampil seperti baru',
          fullDescription: 'Layanan Repaint mengembalikan warna sepatu Anda yang sudah pudar atau memberikan tampilan baru dengan warna pilihan. Kami menggunakan cat premium dan teknik profesional untuk hasil maksimal.',
          price: 'Rp 120.000',
          features: [
            'Pembersihan mendalam sebelum pewarnaan',
            'Penggunaan cat premium yang tahan lama',
            'Finishing sesuai dengan material sepatu',
            'Pelapisan pelindung anti air',
            'Pewarnaan presisi pada detail sepatu'
          ],
          duration: '3-5 hari kerja',
          featured: false
        }
      ],
      
      // Steps data
      steps: [
        {
          title: 'Pesan',
          description: 'Pilih layanan dan jadwalkan pengambilan'
        },
        {
          title: 'Proses',
          description: 'Kami membersihkan dengan teliti dan profesional'
        },
        {
          title: 'Terima',
          description: 'Sepatu diantar ke lokasi Anda dalam kondisi bersih'
        }
      ],
      
      // Testimonials data
      testimonials: [
        {
          quote: 'Sepatu kesayangan saya kembali seperti baru! Sangat puas dengan hasilnya.',
          author: 'Budi Santoso',
          rating: 5
        },
        {
          quote: 'Proses pengambilan dan pengantaran sangat tepat waktu. Sepatu bersih sempurna!',
          author: 'Lina Wijaya',
          rating: 5
        },
        {
          quote: 'Saya sudah mencoba beberapa layanan cuci sepatu, tapi OhMyWash yang terbaik. Hasilnya benar-benar memuaskan.',
          author: 'Ahmad Ridwan',
          rating: 5
        },
        {
          quote: 'Sepatu putih saya yang sudah sangat kotor kembali putih bersih. Terima kasih OhMyWash!',
          author: 'Dewi Anggraini',
          rating: 4
        }
      ]
    }
  },
  computed: {
    currentYear() {
      return new Date().getFullYear();
    },
    minDate() {
      const today = new Date();
      const tomorrow = new Date(today);
      tomorrow.setDate(tomorrow.getDate() + 1);
      return tomorrow.toISOString().split('T')[0];
    }
  },
  mounted() {
    window.addEventListener('scroll', this.handleScroll);
    this.setupIntersectionObserver();
    
    // Check if there's a hash in the URL
    if (window.location.hash) {
      const id = window.location.hash.substring(1);
      this.scrollToSection(id);
    }
  },
  beforeUnmount() {
    window.removeEventListener('scroll', this.handleScroll);
  },
  methods: {
    // Navigation functions
    scrollToSection(sectionId, closeMobileMenu = false) {
      const element = this.$refs[sectionId];
      
      if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
        this.activeSection = sectionId;
      }
      
      if (closeMobileMenu) {
        this.showMobileMenu = false;
      }
    },
    
    handleScroll() {
      const sections = ['home', 'services', 'how-it-works', 'testimonials', 'order'];
      
      // Find which section is currently in view
      for (const section of sections) {
        const element = this.$refs[section];
        if (element) {
          const rect = element.getBoundingClientRect();
          const inView = rect.top <= 150 && rect.bottom >= 150;
          
          if (inView) {
            this.activeSection = section;
            break;
          }
        }
      }
    },
    
    setupIntersectionObserver() {
      const options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
      };
      
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('animate');
          }
        });
      }, options);
      
      // Observe all section titles and cards
      document.querySelectorAll('.section-title, .service-card, .step, .testimonial-card').forEach(el => {
        observer.observe(el);
      });
    },
    
    toggleMobileMenu() {
      this.showMobileMenu = !this.showMobileMenu;
    },
    
    // Testimonial carousel functions
    nextTestimonial() {
      this.currentTestimonialIndex = (this.currentTestimonialIndex + 1) % this.testimonials.length;
    },
    
    prevTestimonial() {
      this.currentTestimonialIndex = (this.currentTestimonialIndex - 1 + this.testimonials.length) % this.testimonials.length;
    },
    
    setTestimonial(index) {
      this.currentTestimonialIndex = index;
    },
    
    // Service modal functions
    selectService(service) {
      this.selectedService = service;
      this.showServiceModal = true;
    },
    
    closeServiceModal() {
      this.showServiceModal = false;
    },
    
    orderSelectedService() {
      this.formData.service = this.selectedService.id;
      this.closeServiceModal();
      this.scrollToSection('order');
    },
    
    // Order form functions
    validateForm() {
      let isValid = true;
      this.errors = {
        name: '',
        phone: '',
        address: '',
        service: '',
        pickupDate: ''
      };
      
      // Validate name
      if (!this.formData.name.trim()) {
        this.errors.name = 'Nama lengkap harus diisi';
        isValid = false;
      }
      
      // Validate phone
      if (!this.formData.phone.trim()) {
        this.errors.phone = 'Nomor telepon harus diisi';
        isValid = false;
      } else if (!/^[0-9+\-\s]{10,15}$/.test(this.formData.phone)) {
        this.errors.phone = 'Nomor telepon tidak valid';
        isValid = false;
      }
      
      // Validate address
      if (!this.formData.address.trim()) {
        this.errors.address = 'Alamat pengambilan harus diisi';
        isValid = false;
      }
      
      // Validate service
      if (!this.formData.service) {
        this.errors.service = 'Layanan harus dipilih';
        isValid = false;
      }
      
      // Validate pickup date
      if (!this.formData.pickupDate) {
        this.errors.pickupDate = 'Tanggal pengambilan harus diisi';
        isValid = false;
      }
      
      return isValid;
    },
    
    async submitOrder() {
      if (!this.validateForm()) {
        return;
      }
      
      // Show loading state
      this.loading = true;
      
      try {
        // Simulate API request
        await new Promise(resolve => setTimeout(resolve, 1500));
        
        // Show success message
        this.orderSuccess = true;
        this.resetForm();
      } catch (error) {
        console.error('Order submission error:', error);
        alert('Terjadi kesalahan saat mengirim pesanan. Silakan coba lagi.');
      } finally {
        this.loading = false;
      }
    },
    
    resetForm() {
      this.formData = {
        name: '',
        phone: '',
        address: '',
        service: '',
        pickupDate: '',
        notes: ''
      };
    },
    
    formatDate(dateString) {
      if (!dateString) return '';
      
      const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString('id-ID', options);
    }
  }
}
</script>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

:root {
  --primary-color: #4a90e2;
  --accent-color: #ff6b6b;
  --dark-color: #333;
  --light-color: #f8f9fa;
  --text-color: #333;
  --border-radius: 8px;
  --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

body {
  background-color: #f5f7fa;
  color: var(--text-color);
  line-height: 1.6;
  scroll-behavior: smooth;
}

.app-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
  position: relative;
}

/* Header Styles */
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 0;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  position: sticky;
  top: 0;
  background-color: #fff;
  z-index: 1000;
}

.logo-container {
  display: flex;
  flex-direction: column;
}

.logo {
  display: flex;
  align-items: center;
  gap: 10px;
}

.logo .icon {
  font-size: 2rem;
}

.logo h1 {
  font-size: 1.8rem;
  font-weight: 700;
  color: var(--primary-color);
}

.tagline {
  font-size: 0.9rem;
  color: #666;
}

.main-nav {
  display: flex;
  gap: 20px;
}

.nav-item {
  text-decoration: none;
  color: var(--dark-color);
  font-weight: 500;
  padding: 5px 10px;
  border-radius: var(--border-radius);
  transition: all 0.3s ease;
}

.nav-item:hover, .nav-item.active {
  color: var(--primary-color);
  background-color: rgba(74, 144, 226, 0.1);
}

/* Mobile Menu */
.mobile-menu-toggle {
  display: none;
  flex-direction: column;
  justify-content: space-between;
  width: 30px;
  height: 21px;
  cursor: pointer;
}

.mobile-menu-toggle .bar {
  height: 3px;
  width: 100%;
  background-color: var(--dark-color);
  border-radius: 3px;
}

.mobile-menu {
  display: none;
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
  background-color: white;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  flex-direction: column;
  padding: 20px;
  z-index: 1000;
  opacity: 0;
  transform: translateY(-20px);
  transition: all 0.3s ease;
}

.mobile-menu.show {
  opacity: 1;
  transform: translateY(0);
}

.mobile-menu a {
  padding: 15px;
  text-decoration: none;
  color: var(--dark-color);
  border-bottom: 1px solid #eee;
  font-weight: 500;
}

.mobile-menu a:last-child {
  border-bottom: none;
}

/* Hero Styles */
.hero {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 80px 0 60px;
  gap: 40px;
}

.hero-content {
  flex: 1;
}

.hero-content h2 {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 20px;
  color: var(--dark-color);
}

.hero-content p {
  font-size: 1.1rem;
  color: #666;
  margin-bottom: 30px;
  max-width: 500px;
}

.hero-image {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
}

.hero-image .actual-image {
  max-width: 100%;
  height: auto;
  border-radius: var(--border-radius);
  box-shadow: var(--box-shadow);
  transition: all 0.3s ease;
}

.hero-image .actual-image:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
}

.shoe-icon {
  font-size: 5rem;
  margin-bottom: 20px;
}

.placeholder-image p {
  font-size: 1.5rem;
  font-weight: 600;
}

.cta-button {
  background-color: var(--primary-color);
  color: white;
  border: none;
  padding: 12px 30px;
  font-size: 1rem;
  font-weight: 600;
  border-radius: var(--border-radius);
  cursor: pointer;
  transition: all 0.3s ease;
}

.cta-button:hover {
  background-color: #3a7bc8;
  transform: translateY(-2px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

/* Section Styles */
section {
  padding: 80px 0;
  scroll-margin-top: 80px;
}

.section-title {
  text-align: center;
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 40px;
  color: var(--dark-color);
  position: relative;
}

.section-title:after {
  content: '';
  position: absolute;
  bottom: -10px;
  left: 50%;
  transform: translateX(-50%);
  width: 60px;
  height: 3px;
  background-color: var(--primary-color);
  border-radius: 3px;
}

/* Services Styles */
.service-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 30px;
  margin-top: 40px;
}

.service-card {
  background-color: white;
  border-radius: var(--border-radius);
  padding: 30px;
  box-shadow: var(--box-shadow);
  text-align: center;
  transition: all 0.3s ease;
  cursor: pointer;
  border: 1px solid rgba(0, 0, 0, 0.08);
}

.service-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
}

.service-card.featured {
  border: 2px solid var(--primary-color);
  position: relative;
}

.service-card.featured:before {
  content: 'POPULER';
  position: absolute;
  top: -12px;
  right: 20px;
  background-color: var(--primary-color);
  color: white;
  padding: 5px 15px;
  font-size: 0.8rem;
  font-weight: 600;
  border-radius: 20px;
}

.service-icon {
  font-size: 3rem;
  margin-bottom: 20px;
  color: var(--primary-color);
}

.service-card h3 {
  font-size: 1.5rem;
  margin-bottom: 15px;
  color: var(--dark-color);
}

.service-card p {
  color: #666;
  margin-bottom: 20px;
}

.price {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--accent-color);
  margin-bottom: 20px;
}

.order-button {
  background-color: var(--primary-color);
  color: white;
  border: none;
  padding: 10px 25px;
  font-size: 0.9rem;
  font-weight: 600;
  border-radius: var(--border-radius);
  cursor: pointer;
  transition: all 0.3s ease;
}

.order-button:hover {
  background-color: #3a7bc8;
}

/* How It Works Styles */
.how-it-works {
  background-color: var(--light-color);
}

.steps {
  display: flex;
  justify-content: space-between;
  gap: 30px;
  margin-top: 40px;
}

.step {
  flex: 1;
  background-color: white;
  border-radius: var(--border-radius);
  padding: 30px;
  box-shadow: var(--box-shadow);
  text-align: center;
  position: relative;
  transition: all 0.3s ease;
}

.step:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
}

.step:not(:last-child):after {
  content: '→';
  position: absolute;
  right: -20px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 2rem;
  color: var(--primary-color);
}

.step-number {
  width: 50px;
  height: 50px;
  background-color: var(--primary-color);
  color: white;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.5rem;
  font-weight: 700;
  margin: 0 auto 20px;
}

.step h3 {
  font-size: 1.5rem;
  margin-bottom: 15px;
  color: var(--dark-color);
}

.step p {
  color: #666;
}

/* Testimonials Styles */
.testimonial-carousel {
  position: relative;
  max-width: 800px;
  margin: 0 auto;
}

.testimonial-cards {
  position: relative;
  height: 250px;
}

.testimonial-card {
  background-color: white;
  border-radius: var(--border-radius);
  padding: 30px;
  box-shadow: var(--box-shadow);
  text-align: center;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  opacity: 0;
  transition: opacity 0.5s ease;
}

.testimonial-card.active {
  opacity: 1;
}

.quote {
  font-size: 1.1rem;
  font-style: italic;
  color: #444;
  margin-bottom: 20px;
}

.testimonial-author {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 15px;
}

.avatar {
  width: 50px;
  height: 50px;
  background-color: #e0e0e0;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.5rem;
}

.author-info h4 {
  font-size: 1.1rem;
  color: var(--dark-color);
  margin-bottom: 5px;
}

.rating {
  color: #ffc107;
}

.carousel-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: white;
  border: 1px solid #e0e0e0;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  font-size: 1.5rem;
  z-index: 10;
  transition: all 0.3s ease;
}

.carousel-btn:hover {
  background-color: var(--primary-color);
  color: white;
  border-color: var(--primary-color);
}

.prev {
  left: -20px;
}

.next {
  right: -20px;
}

.testimonial-dots {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin-top: 30px;
}

.dot {
  width: 12px;
  height: 12px;
  background-color: #e0e0e0;
  border-radius: 50%;
  cursor: pointer;
  transition: all 0.3s ease;
}

.dot.active {
  background-color: var(--primary-color);
  transform: scale(1.2);
}

/* Order Form Styles */
.order-form {
  background-color: var(--light-color);
}

.form {
  background-color: white;
  border-radius: var(--border-radius);
  padding: 40px;
  box-shadow: var(--box-shadow);
  max-width: 800px;
  margin: 0 auto;
}

.form-row {
  display: flex;
  gap: 20px;
  margin-bottom: 20px;
}

.form-group {
  flex: 1;
  display: flex;
  flex-direction: column;
}

label {
  margin-bottom: 8px;
  font-weight: 500;
  color: var(--dark-color);
}

.required {
  color: var(--accent-color);
}

input, select, textarea {
  padding: 12px 15px;
  border: 1px solid #ddd;
  border-radius: var(--border-radius);
  font-size: 1rem;
  transition: all 0.3s ease;
}

textarea {
  min-height: 100px;
  resize: vertical;
}

input:focus, select:focus, textarea:focus {
  outline: none;
  border-color: var(--primary-color);
  box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
}

input.error, select.error, textarea.error {
  border-color: var(--accent-color);
}

.error-message {
  color: var(--accent-color);
  font-size: 0.85rem;
  margin-top: 5px;
}

.submit-button {
  background-color: var(--primary-color);
  color: white;
  border: none;
  padding: 12px 30px;
  font-size: 1rem;
  font-weight: 600;
  border-radius: var(--border-radius);
  cursor: pointer;
  transition: all 0.3s ease;
  display: block;
  margin: 30px auto 0;
  min-width: 200px;
  position: relative;
}

.submit-button:hover {
  background-color: #3a7bc8;
}

.loading-spinner {
  display: inline-block;
  width: 20px;
  height: 20px;
  border: 3px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top-color: white;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

/* Order Success Styles */
.order-success {
  background-color: white;
  border-radius: var(--border-radius);
  padding: 40px;
  box-shadow: var(--box-shadow);
  max-width: 600px;
  margin: 0 auto;
  text-align: center;
}

.success-icon {
  font-size: 5rem;
  color: #4CAF50;
  margin-bottom: 20px;
}

.order-success h3 {
  font-size: 1.8rem;
  color: var(--dark-color);
  margin-bottom: 20px;
}

.order-success p {
  font-size: 1.1rem;
  color: #666;
  margin-bottom: 10px;
}

.order-success .cta-button {
  margin-top: 30px;
}

/* WhatsApp Floating Button */
.whatsapp-float {
  position: fixed;
  bottom: 30px;
  right: 30px;
  width: 60px;
  height: 60px;
  background-color: #25D366;
  color: white;
  border-radius: 50%;
  text-align: center;
  font-size: 2rem;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  text-decoration: none;
  transition: all 0.3s ease;
}

.whatsapp-float:hover {
  transform: scale(1.1);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.whatsapp-icon {
  font-size: 1.8rem;
}

/* Footer Styles */
.footer {
  background-color: var(--dark-color);
  color: white;
  padding: 60px 0 20px;
}

.footer-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 40px;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.footer-logo {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 20px;
}

.footer-logo .icon {
  font-size: 2rem;
}

.footer-logo h3 {
  font-size: 1.5rem;
  color: white;
}

.footer-contact p {
  margin-bottom: 10px;
}

.footer-hours h4, .footer-social h4 {
  font-size: 1.2rem;
  margin-bottom: 15px;
  color: white;
}

.social-icons {
  display: flex;
  gap: 15px;
}

.social-icon {
  width: 40px;
  height: 40px;
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.2rem;
  color: white;
  text-decoration: none;
  transition: all 0.3s ease;
}

.social-icon:hover {
  background-color: var(--primary-color);
  transform: translateY(-3px);
}

.footer-bottom {
  text-align: center;
  padding-top: 30px;
  margin-top: 40px;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  max-width: 1200px;
  margin-left: auto;
  margin-right: auto;
  padding-left: 20px;
  padding-right: 20px;
}

/* Service Modal Styles */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 2000;
}

.modal-content {
  background-color: white;
  border-radius: var(--border-radius);
  max-width: 800px;
  width: 90%;
  max-height: 90vh;
  overflow-y: auto;
  padding: 30px;
  position: relative;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.close-button {
  position: absolute;
  top: 15px;
  right: 15px;
  font-size: 1.8rem;
  color: #666;
  cursor: pointer;
  transition: all 0.3s ease;
}

.close-button:hover {
  color: var(--accent-color);
}

.service-header {
  display: flex;
  align-items: center;
  gap: 20px;
  margin-bottom: 20px;
}

.service-icon.large {
  font-size: 4rem;
}

.price.large {
  font-size: 2rem;
  margin: 20px 0;
}

.service-description {
  margin-bottom: 30px;
}

.service-features {
  margin-bottom: 30px;
}

.service-features h3, .service-duration h3 {
  font-size: 1.3rem;
  margin-bottom: 15px;
  color: var(--dark-color);
}

.service-features ul {
  list-style-type: none;
}

.service-features li {
  padding: 8px 0;
  position: relative;
  padding-left: 30px;
}

.service-features li:before {
  content: '✓';
  color: var(--primary-color);
  position: absolute;
  left: 0;
}

.service-duration {
  margin-bottom: 30px;
}

/* Animation Styles */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.section-title, .service-card, .step, .testimonial-card {
  opacity: 0;
  transform: translateY(20px);
  transition: all 0.5s ease;
}

.section-title.animate, .service-card.animate, .step.animate, .testimonial-card.animate {
  opacity: 1;
  transform: translateY(0);
}

/* Responsive Styles */
@media (max-width: 1024px) {
  .hero-image .actual-image {
    max-width: 400px;
  }
  
  .hero-content p {
    margin-left: auto;
    margin-right: auto;
  }
  
  .placeholder-image {
    width: 100%;
    max-width: 400px;
    height: 250px;
  }
}

@media (max-width: 768px) {
  .main-nav {
    display: none;
  }
  
  .mobile-menu-toggle {
    display: flex;
  }
  
  .mobile-menu {
    display: flex;
  }
  
  .steps {
    flex-direction: column;
  }
  
  .step:not(:last-child):after {
    content: '↓';
    position: absolute;
    right: 50%;
    top: auto;
    bottom: -30px;
    transform: translateX(50%);
  }
  
  .form-row {
    flex-direction: column;
    gap: 10px;
  }
  
  .service-card {
    min-height: auto;
  }
  
  .carousel-btn {
    width: 30px;
    height: 30px;
    font-size: 1rem;
  }
  
  .prev {
    left: 0;
  }
  
  .next {
    right: 0;
  }
}

@media (max-width: 480px) {
  .hero-content h2 {
    font-size: 2rem;
  }
  
  .section-title {
    font-size: 1.8rem;
  }
  
  .form {
    padding: 20px;
  }
}
</style>