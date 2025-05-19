<template>
  <div class="app-container">
    <!-- Header Section -->
    <header class="header">
      <div class="logo-container">
        <div class="logo">
          <div class="logo-icon">
            <span class="icon">👟</span>
            <span class="icon-shadow"></span>
          </div>
          <h1>OhMyWash</h1>
        </div>
        <p class="tagline">Premium Shoe Care Specialists</p>
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
  <div class="hero-background">
    <div class="hero-shape shape-1"></div>
    <div class="hero-shape shape-2"></div>
  </div>
  <div class="hero-content">
    <h2>Revitalize Your <span class="highlight">Footwear</span></h2>
    <p>Professional shoe cleaning and restoration services using premium techniques and eco-friendly products</p>
    <div class="hero-buttons">
      <button class="cta-button primary" @click="scrollToSection('order')">
        <span class="btn-icon">🧼</span> Book Now
      </button>
      <button class="cta-button secondary" @click="scrollToSection('services')">
        <span class="btn-icon">👀</span> View Services
      </button>
    </div>
    <div class="hero-stats">
      <div class="stat-item">
        <span class="stat-number">5000+</span>
        <span class="stat-label">Shoes Cleaned</span>
      </div>
      <div class="stat-item">
        <span class="stat-number">98%</span>
        <span class="stat-label">Satisfaction</span>
      </div>
      <div class="stat-item">
        <span class="stat-number">24h</span>
        <span class="stat-label">Turnaround</span>
      </div>
    </div>
  </div>
  <div class="hero-image">
    <div class="image-container">
      <img src="/assets/ohmywash.jpeg" alt="OhMyWash Professional Shoe Cleaning Service" class="actual-image">
      <div class="image-accent"></div>
    </div>
    <div class="floating-badge">
      <span class="badge-text">Premium Service</span>
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
    <div class="service-icon-container">
      <div class="service-icon">{{ service.icon }}</div>
    </div>
    <h3>{{ service.name }}</h3>
    <p>{{ service.description }}</p>
    <p class="price">{{ service.price }}</p>
    <ul class="service-features-preview">
      <li v-for="(feature, idx) in service.features.slice(0, 2)" :key="idx">
        {{ feature }}
      </li>
    </ul>
    <button class="order-button">
      <span>Select</span>
      <span class="arrow">→</span>
    </button>
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
            :class="{ 'active': currentTestimonialIndex === index }"
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
      isMobile: false,
      
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
    // Check for mobile and set initial state
    this.checkMobile();
    
    // Add event listeners
    window.addEventListener('scroll', this.handleScroll);
    window.addEventListener('resize', this.handleResize);
    this.setupIntersectionObserver();
    
    // Check if there's a hash in the URL
    if (window.location.hash) {
      const id = window.location.hash.substring(1);
      this.scrollToSection(id);
    }
  },
  beforeUnmount() {
    window.removeEventListener('scroll', this.handleScroll);
    window.removeEventListener('resize', this.handleResize);
  },
  methods: {
    // Check if device is mobile
    checkMobile() {
      this.isMobile = window.innerWidth <= 768;
    },
    
    // Handle window resize
    handleResize() {
      this.checkMobile();
      if (!this.isMobile && this.showMobileMenu) {
        this.showMobileMenu = false;
      }
    },
    
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
      
      // Add no-scroll to body when menu is open
      if (this.showMobileMenu) {
        document.body.classList.add('no-scroll');
      } else {
        document.body.classList.remove('no-scroll');
      }
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
      
      // Prevent background scrolling when modal is open
      document.body.classList.add('no-scroll');
    },
    
    closeServiceModal() {
      this.showServiceModal = false;
      
      // Re-enable scrolling
      document.body.classList.remove('no-scroll');
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
  --primary-color: #00b4d8; /* Fresh blue */
  --secondary-color: #0077b6; /* Deeper blue for depth */
  --accent-color: #ff9e00; /* Vibrant orange for CTAs */
  --dark-color: #1d3557; /* Rich dark blue instead of black */
  --light-color: #f8f9fa;
  --text-color: #2b2d42;
  --background-color: #f7f9fc;
  --card-background: #ffffff;
  --border-radius: 12px;
  --box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
  --transition-speed: 0.3s;
}

body {
  background-color: #f5f7fa;
  color: var(--text-color);
  line-height: 1.6;
  scroll-behavior: smooth;
}

.no-scroll {
  overflow: hidden;
}

.app-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
  position: relative;
}

/* Header Styles */
.header {
  backdrop-filter: blur(10px);
  background-color: rgba(255, 255, 255, 0.9);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 0;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  position: sticky;
  top: 0;
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

.logo-icon {
  position: relative;
  display: inline-block;
}

.icon {
  font-size: 2.2rem;
  position: relative;
  z-index: 2;
  }

.icon-shadow {
  position: absolute;
  top: 5px;
  left: 5px;
  width: 100%;
  height: 100%;
  background-color: var(--accent-color);
  filter: blur(8px);
  opacity: 0.4;
  border-radius: 50%;
  z-index: 1;
}

.logo h1 {
  font-size: 2rem;
  font-weight: 800;
  background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  letter-spacing: -0.5px;
}

.tagline {
  font-size: 0.9rem;
  color: var(--secondary-color);
  font-weight: 500;
  letter-spacing: 1px;
  text-transform: uppercase;
}

.main-nav {
  display: flex;
  gap: 20px;
}

.nav-item {
  font-weight: 600;
  position: relative;
  padding: 8px 16px;
}

.nav-item::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  width: 0;
  height: 2px;
  background-color: var(--primary-color);
  transition: all 0.3s ease;
  transform: translateX(-50%);
}

.nav-item:hover::after, .nav-item.active::after {
  width: 80%;
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
  transition: all var(--transition-speed) ease;
}

.mobile-menu {
  display: none;
  position: fixed;
  top: 70px;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: white;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  flex-direction: column;
  padding: 20px;
  z-index: 1000;
  opacity: 0;
  transform: translateX(-100%);
  transition: all var(--transition-speed) ease;
}

.mobile-menu.show {
  opacity: 1;
  transform: translateX(0);
}

.mobile-menu a {
  padding: 15px;
  text-decoration: none;
  color: var(--dark-color);
  border-bottom: 1px solid #eee;
  font-weight: 500;
  font-size: 1.2rem;
  transition: all var(--transition-speed) ease;
}

.mobile-menu a:hover {
  color: var(--primary-color);
  background-color: rgba(74, 144, 226, 0.05);
}

.mobile-menu a:last-child {
  border-bottom: none;
}

/* Hero Styles */
.hero {
  position: relative;
  padding: 120px 0 100px;
  overflow: hidden;
}

.hero-background {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: -1;
}

.hero-shape {
  position: absolute;
  border-radius: 50%;
}

.shape-1 {
  top: -100px;
  right: -100px;
  width: 400px;
  height: 400px;
  background: linear-gradient(135deg, rgba(0, 180, 216, 0.1), rgba(0, 119, 182, 0.1));
}

.shape-2 {
  bottom: -150px;
  left: -150px;
  width: 500px;
  height: 500px;
  background: linear-gradient(135deg, rgba(255, 158, 0, 0.05), rgba(255, 158, 0, 0.1));
}

.hero-content {
  flex: 1;
}

.hero-content h2 {
  font-size: 3.5rem;
  font-weight: 800;
  margin-bottom: 25px;
  line-height: 1.2;
}

.highlight {
  color: var(--primary-color);
  position: relative;
}

.highlight::after {
  content: '';
  position: absolute;
  bottom: 5px;
  left: 0;
  width: 100%;
  height: 8px;
  background-color: rgba(0, 180, 216, 0.2);
  z-index: -1;
}

.hero-content p {
  font-size: 1.2rem;
  line-height: 1.6;
  color: var(--text-color);
  opacity: 0.8;
  max-width: 550px;
  margin-bottom: 35px;
}

.hero-buttons {
  display: flex;
  gap: 15px;
  margin-bottom: 40px;
}

.hero-image {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
}

.placeholder-image {
  width: 100%;
  height: 350px;
  background-color: #f0f0f0;
  border-radius: var(--border-radius);
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
  box-shadow: var(--box-shadow);
}

.actual-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* CTA Button Styles */
.cta-button {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 14px 28px;
  border-radius: 50px;
  font-weight: 600;
  font-size: 1.05rem;
  transition: all 0.3s ease;
}

.cta-button.primary {
  background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
  color: white;
  box-shadow: 0 10px 20px rgba(0, 119, 182, 0.3);
}

.cta-button.secondary {
  background-color: white;
  color: var(--primary-color);
  border: 2px solid var(--primary-color);
}

.btn-icon {
  font-size: 1.2rem;
}

.hero-stats {
  display: flex;
  gap: 40px;
}

.stat-item {
  display: flex;
  flex-direction: column;
}

.stat-number {
  font-size: 1.8rem;
  font-weight: 700;
  color: var(--primary-color);
}

.stat-label {
  font-size: 0.9rem;
  color: var(--text-color);
  opacity: 0.7;
}

.image-container {
  position: relative;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.actual-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.image-container:hover .actual-image {
  transform: scale(1.05);
}

.image-accent {
  position: absolute;
  bottom: -10px;
  right: -10px;
  width: 70%;
  height: 70%;
  background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
  opacity: 0.2;
  border-radius: 20px;
  z-index: -1;
}

.floating-badge {
  position: absolute;
  top: 30px;
  right: -20px;
  background: linear-gradient(135deg, var(--accent-color), #ff7b00);
  color: white;
  padding: 10px 25px;
  border-radius: 50px;
  font-weight: 600;
  box-shadow: 0 5px 15px rgba(255, 158, 0, 0.3);
  transform: rotate(5deg);
}

.cta-button:hover {
  background-color: #3a80d2;
  transform: translateY(-2px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.cta-button:active {
  transform: translateY(0);
}

/* Services Styles */
.services {
  padding: 80px 0;
  background-color: #fff;
}

.section-title {
  text-align: center;
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 50px;
  color: var(--dark-color);
  position: relative;
}

.section-title::after {
  content: '';
  position: absolute;
  bottom: -10px;
  left: 50%;
  transform: translateX(-50%);
  width: 60px;
  height: 3px;
  background-color: var(--primary-color);
}

.service-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 40px;
}

.service-card {
  background-color: var(--card-background);
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
  padding: 40px 30px;
  transition: all 0.4s ease;
  border: 1px solid rgba(0, 0, 0, 0.03);
}


.service-card:hover {
  transform: translateY(-15px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.service-card.featured::before {
  content: 'Populer';
  position: absolute;
  top: 10px;
  right: -30px;
  background-color: var(--accent-color);
  color: white;
  padding: 5px 40px;
  font-size: 0.8rem;
  font-weight: 500;
  transform: rotate(45deg);
}

.service-icon-container {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, rgba(0, 180, 216, 0.1), rgba(0, 119, 182, 0.1));
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 25px;
}

.service-icon {
  font-size: 2.5rem;
}

.service-card h3 {
  font-size: 1.5rem;
  font-weight: 700;
  margin-bottom: 15px;
  color: var(--dark-color);
}

.service-card p {
  color: var(--text-color);
  opacity: 0.8;
  margin-bottom: 20px;
  line-height: 1.6;
}

.price {
  font-size: 1.4rem;
  font-weight: 800;
  color: var(--primary-color);
  margin-bottom: 20px;
}

.service-features-preview {
  list-style: none;
  margin-bottom: 25px;
}

.service-features-preview li {
  padding: 8px 0;
  position: relative;
  padding-left: 25px;
  color: var(--text-color);
  opacity: 0.8;
}

.service-features-preview li::before {
  content: '✓';
  position: absolute;
  left: 0;
  color: var(--primary-color);
  font-weight: bold;
}

.order-button {
  width: 100%;
  padding: 12px 0;
  background-color: var(--card-background);
  color: var(--primary-color);
  border: 2px solid var(--primary-color);
  border-radius: 50px;
  font-size: 1rem;
  font-weight: 600;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  transition: all 0.3s ease;
}

.order-button:hover {
  background-color: var(--primary-color);
  color: white;
}

.order-button .arrow {
  transition: transform 0.3s ease;
}

.order-button:hover .arrow {
  transform: translateX(5px);
}

.service-card.featured {
  background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
  color: white;
}

.service-card.featured h3,
.service-card.featured p,
.service-card.featured .price,
.service-card.featured .service-features-preview li {
  color: white;
  opacity: 1;
}

.service-card.featured .service-features-preview li::before {
  color: var(--accent-color);
}

.service-card.featured .service-icon-container {
  background: rgba(255, 255, 255, 0.2);
}

.service-card.featured .order-button {
  background-color: white;
  color: var(--primary-color);
  border-color: white;
}

.service-card.featured .order-button:hover {
  background-color: var(--accent-color);
  color: white;
  border-color: var(--accent-color);
}

.service-card.featured::before {
  content: 'Popular';
}

/* How It Works Styles */
.how-it-works {
  padding: 80px 0;
  background-color: #f8f9fa;
}

.steps {
  display: flex;
  justify-content: space-between;
  gap: 30px;
  max-width: 900px;
  margin: 0 auto;
}

.step {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  padding: 30px;
  background-color: #fff;
  border-radius: var(--border-radius);
  box-shadow: var(--box-shadow);
  transition: all var(--transition-speed) ease;
}

.step:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.step-number {
  width: 40px;
  height: 40px;
  background-color: var(--primary-color);
  color: white;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.2rem;
  font-weight: 600;
  margin-bottom: 20px;
}

.step h3 {
  font-size: 1.2rem;
  font-weight: 600;
  margin-bottom: 15px;
  color: var(--dark-color);
}

.step p {
  color: #666;
}

/* Testimonials Styles */
.testimonials {
  padding: 80px 0;
  background-color: #fff;
}

.testimonial-carousel {
  position: relative;
  max-width: 800px;
  margin: 0 auto;
  overflow: hidden;
}

.testimonial-cards {
  display: flex;
  transition: all 0.5s ease;
}

.testimonial-card {
  flex: 0 0 100%;
  padding: 30px;
  background-color: #f8f9fa;
  border-radius: var(--border-radius);
  box-shadow: var(--box-shadow);
  opacity: 0;
  transform: scale(0.9);
  transition: all var(--transition-speed) ease;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
}

.testimonial-card.active {
  opacity: 1;
  transform: scale(1);
  position: relative;
}

.quote {
  font-style: italic;
  font-size: 1.1rem;
  color: #444;
  margin-bottom: 20px;
  position: relative;
}

.quote::before, .quote::after {
  content: '"';
  font-size: 2rem;
  color: #ddd;
}

.testimonial-author {
  display: flex;
  align-items: center;
  gap: 15px;
}

.avatar {
  width: 50px;
  height: 50px;
  background-color: #eee;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.5rem;
}

.author-info h4 {
  font-size: 1rem;
  font-weight: 600;
}

.rating {
  color: #ffd700;
  margin-top: 5px;
}

.carousel-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 40px;
  height: 40px;
  background-color: white;
  border: none;
  border-radius: 50%;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  font-size: 1.2rem;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  z-index: 10;
  transition: all var(--transition-speed) ease;
}

.carousel-btn:hover {
  background-color: var(--primary-color);
  color: white;
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
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background-color: #ddd;
  cursor: pointer;
  transition: all var(--transition-speed) ease;
}

.dot.active, .dot:hover {
  background-color: var(--primary-color);
}

/* Order Form Styles */
.order-form {
  padding: 80px 0;
  background-color: #f8f9fa;
}

.form {
  max-width: 800px;
  margin: 0 auto;
  background-color: #fff;
  padding: 40px;
  border-radius: var(--border-radius);
  box-shadow: var(--box-shadow);
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
  font-weight: 500;
  margin-bottom: 8px;
  color: var(--dark-color);
}

.required {
  color: var(--accent-color);
}

input, textarea, select {
  padding: 12px 15px;
  border: 1px solid #ddd;
  border-radius: var(--border-radius);
  font-size: 1rem;
  transition: all var(--transition-speed) ease;
}

input:focus, textarea:focus, select:focus {
  outline: none;
  border-color: var(--primary-color);
  box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.1);
}

input.error, textarea.error, select.error {
  border-color: var(--accent-color);
}

.error-message {
  color: var(--accent-color);
  font-size: 0.85rem;
  margin-top: 5px;
}

textarea {
  resize: vertical;
  min-height: 100px;
}

.submit-button {
  padding: 12px 24px;
  background-color: var(--primary-color);
  color: white;
  border: none;
  border-radius: var(--border-radius);
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all var(--transition-speed) ease;
  display: block;
  margin: 30px auto 0;
  min-width: 200px;
}

.submit-button:hover {
  background-color: #3a80d2;
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

/* Order Success Message */
.order-success {
  max-width: 600px;
  margin: 0 auto;
  background-color: #fff;
  padding: 40px;
  border-radius: var(--border-radius);
  box-shadow: var(--box-shadow);
  text-align: center;
}

.success-icon {
  font-size: 3rem;
  color: #2ecc71;
  margin-bottom: 20px;
}

.order-success h3 {
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 20px;
  color: var(--dark-color);
}

.order-success p {
  margin-bottom: 15px;
  color: #666;
}

.order-success .cta-button {
  margin-top: 20px;
}

/* WhatsApp Float Button */
.whatsapp-float {
  position: fixed;
  bottom: 30px;
  right: 30px;
  width: 60px;
  height: 60px;
  background-color: #25d366;
  color: white;
  border-radius: 50%;
  text-align: center;
  font-size: 30px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
  z-index: 100;
  display: flex;
  justify-content: center;
  align-items: center;
  text-decoration: none;
  transition: all var(--transition-speed) ease;
}

.whatsapp-float:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
}

.whatsapp-icon {
  font-size: 2rem;
}

/* Footer Styles */
.footer {
  background-color: var(--dark-color);
  color: white;
  padding: 60px 0 20px;
}

.footer-content {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 40px;
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
  font-weight: 700;
  color: white;
}

.footer-contact p,
.footer-hours p {
  margin-bottom: 10px;
  font-size: 0.9rem;
  color: #ccc;
}

.footer h4 {
  font-size: 1.1rem;
  font-weight: 600;
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
  color: white;
  text-decoration: none;
  font-size: 1.2rem;
  transition: all var(--transition-speed) ease;
}

.social-icon:hover {
  background-color: var(--primary-color);
  transform: translateY(-3px);
}

.footer-bottom {
  max-width: 1200px;
  margin: 40px auto 0;
  padding: 20px;
  text-align: center;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.footer-bottom p {
  font-size: 0.9rem;
  color: #aaa;
}

/* Modal Styles */
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
  padding: 40px;
  border-radius: var(--border-radius);
  max-width: 800px;
  width: 100%;
  max-height: 90vh;
  overflow-y: auto;
  position: relative;
}

.close-button {
  position: absolute;
  top: 15px;
  right: 15px;
  font-size: 1.5rem;
  cursor: pointer;
  transition: all var(--transition-speed) ease;
}

.close-button:hover {
  color: var(--primary-color);
}

.service-details {
  text-align: center;
}

.service-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 20px;
}

.service-icon.large {
  font-size: 4rem;
  margin-bottom: 15px;
}

.price.large {
  font-size: 1.5rem;
  margin-bottom: 30px;
}

.service-description {
  margin-bottom: 30px;
  text-align: left;
}

.service-features {
  text-align: left;
  margin-bottom: 30px;
}

.service-features h3,
.service-duration h3 {
  font-size: 1.2rem;
  font-weight: 600;
  margin-bottom: 10px;
  color: var(--dark-color);
}

.service-features ul {
  list-style-type: none;
}

.service-features li {
  padding: 5px 0 5px 25px;
  position: relative;
}

.service-features li::before {
  content: '✓';
  position: absolute;
  left: 0;
  color: var(--primary-color);
  font-weight: bold;
}

.service-duration {
  text-align: left;
  margin-bottom: 30px;
}

/* Animation classes */
.section-title, .service-card, .step, .testimonial-card {
  opacity: 0;
  transform: translateY(30px);
  transition: all 0.5s ease;
}

.animate {
  opacity: 1;
  transform: translateY(0);
}

/* Responsive Styles */
@media (max-width: 1024px) {
  .hero {
    flex-direction: column;
    padding: 60px 0 40px;
  }
  
  .hero-content {
    text-align: center;
    margin-bottom: 30px;
  }
  
  .hero-content p {
    margin: 0 auto 30px;
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
  
  .form-row {
    flex-direction: column;
    gap: 10px;
  }
  
  .carousel-btn {
    width: 30px;
    height: 30px;
    font-size: 1rem;
  }
  
  .prev {
    left: 10px;
  }
  
  .next {
    right: 10px;
  }
  
  .testimonial-card {
    padding: 20px;
  }
  
  .modal-content {
    padding: 20px;
    width: 90%;
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
  
  .whatsapp-float {
    width: 50px;
    height: 50px;
    bottom: 20px;
    right: 20px;
  }
  
  .whatsapp-icon {
    font-size: 1.5rem;
  }
}
</style>