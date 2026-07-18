import React from 'react'
import './App.css'
import heroImage from './assets/hero.png'

const features = [
  {
    title: 'Premium solar panels',
    description: 'High-efficiency panels built for long life and reliable performance.',
  },
  {
    title: 'Battery backups',
    description: 'Robust energy storage solutions for homes, offices, and off-grid systems.',
  },
  {
    title: 'Smart inverters',
    description: 'Modern power management designed to maximize savings and uptime.',
  },
]

const products = [
  {
    name: 'Solar Panel Pack',
    price: '₦220,000',
    details: 'Durable, high-output panels with a sleek low-profile design.',
  },
  {
    name: 'Hybrid Inverter',
    price: '₦145,000',
    details: 'Stable, efficient inverter with smart monitoring features.',
  },
  {
    name: 'Deep Cycle Battery',
    price: '₦98,000',
    details: 'Long-life battery backup for dependable energy storage.',
  },
]

function App() {
  return (
    <div className="AppShell">
      <header className="topbar container">
        <div className="brand">
          <span className="brand-name">Sparkcart</span>
          <span className="brand-tag">Solar & Power</span>
        </div>

        <nav className="nav-links">
          <a href="#features">Features</a>
          <a href="#products">Products</a>
          <a href="#contact">Contact</a>
        </nav>
      </header>

      <main className="hero-section container">
        <div className="hero-copy">
          <span className="eyebrow">Sell smarter. Shop brighter.</span>
          <h1>Power your world with a premium solar experience.</h1>
          <p className="hero-text">
            Discover curated solar panels, batteries, and power solutions designed for modern homes and businesses.
          </p>
          <div className="hero-actions">
            <a className="btn btn-primary" href="#products">
              Explore products
            </a>
            <a className="btn btn-secondary" href="#contact">
              Contact us
            </a>
          </div>

          <div className="stats-grid">
            <article>
              <strong>120+</strong>
              <span>Solar models</span>
            </article>
            <article>
              <strong>24/7</strong>
              <span>Support</span>
            </article>
            <article>
              <strong>99%</strong>
              <span>Happy customers</span>
            </article>
          </div>
        </div>

        <div className="hero-visual">
          <div className="visual-card">
            <img src={heroImage} alt="Solar energy illustration" />
          </div>
        </div>
      </main>

      <section id="features" className="section feature-section container">
        <div className="section-heading">
          <p className="eyebrow">Why Sparkcart</p>
          <h2>Beautiful solar products for every setup.</h2>
        </div>

        <div className="feature-grid">
          {features.map((feature) => (
            <article key={feature.title} className="feature-card">
              <div className="feature-icon">☀️</div>
              <h3>{feature.title}</h3>
              <p>{feature.description}</p>
            </article>
          ))}
        </div>
      </section>

      <section id="products" className="section products-section container">
        <div className="section-heading">
          <p className="eyebrow">Featured collections</p>
          <h2>Top solar kits for smarter energy.</h2>
        </div>

        <div className="product-grid">
          {products.map((product) => (
            <article key={product.name} className="product-card">
              <h3>{product.name}</h3>
              <p>{product.details}</p>
              <span className="product-price">{product.price}</span>
              <a className="product-link" href="#contact">
                Request quote
              </a>
            </article>
          ))}
        </div>
      </section>

      <section id="contact" className="section contact-section container">
        <div className="contact-card">
          <div>
            <p className="eyebrow">Ready to upgrade?</p>
            <h2>Let’s build a cleaner, brighter energy future.</h2>
          </div>
          <a className="btn btn-primary" href="mailto:hello@sparkcart.example">
            Send us a message
          </a>
        </div>
      </section>

      <footer className="site-footer">
        <p>Sparkcart — a clean purple brand experience for solar and power products.</p>
      </footer>
    </div>
  )
}

export default App
