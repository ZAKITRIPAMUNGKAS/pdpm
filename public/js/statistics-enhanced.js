/**
 * Enhanced Statistics Dashboard
 * Interactive features for statistics visualization
 */

document.addEventListener('DOMContentLoaded', function() {
    initializeStatistics();
    initializeChartVisualization();
    initializeProgressBars();
    initializeHoverEffects();
});

/**
 * Initialize statistics functionality
 */
function initializeStatistics() {
    // Add loading animation to stat items
    const statItems = document.querySelectorAll('.stat-item');
    statItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
            item.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, index * 100);
    });
}

/**
 * Initialize chart visualization
 */
function initializeChartVisualization() {
    const chartContainer = document.getElementById('chartVisualization');
    if (!chartContainer) return;
    
    const statItems = document.querySelectorAll('.stat-item');
    if (statItems.length === 0) return;
    
    // Create simple bar chart
    createBarChart(chartContainer, statItems);
}

/**
 * Create a simple bar chart
 */
function createBarChart(container, statItems) {
    container.innerHTML = '';
    
    const maxValue = Math.max(...Array.from(statItems).map(item => {
        return parseInt(item.querySelector('.badge').textContent.replace(/,/g, ''));
    }));
    
    statItems.forEach((item, index) => {
        const value = parseInt(item.querySelector('.badge').textContent.replace(/,/g, ''));
        const percentage = (value / maxValue) * 100;
        const color = item.dataset.color || '#dc3545';
        
        const barContainer = document.createElement('div');
        barContainer.className = 'chart-bar-container';
        barContainer.style.cssText = `
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            height: 100%;
            justify-content: end;
        `;
        
        const bar = document.createElement('div');
        bar.className = 'chart-bar';
        bar.style.cssText = `
            width: 20px;
            height: ${percentage}%;
            background: linear-gradient(180deg, ${color}, ${color}88);
            border-radius: 10px 10px 0 0;
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            cursor: pointer;
            margin-bottom: 0.5rem;
        `;
        
        // Add shine effect
        const shine = document.createElement('div');
        shine.style.cssText = `
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shimmer 2s infinite;
        `;
        bar.appendChild(shine);
        
        const label = document.createElement('div');
        label.className = 'chart-label';
        label.style.cssText = `
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 500;
            text-align: center;
            writing-mode: vertical-rl;
            text-orientation: mixed;
            max-width: 40px;
            overflow: hidden;
            text-overflow: ellipsis;
        `;
        label.textContent = item.querySelector('.stat-item-title').textContent;
        
        barContainer.appendChild(bar);
        barContainer.appendChild(label);
        container.appendChild(barContainer);
        
        // Add hover effects
        bar.addEventListener('mouseenter', function() {
            this.style.transform = 'scaleY(1.1)';
            this.style.boxShadow = `0 4px 12px ${color}40`;
            
            // Highlight corresponding stat item
            item.style.transform = 'translateX(8px) scale(1.02)';
            item.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.15)';
        });
        
        bar.addEventListener('mouseleave', function() {
            this.style.transform = 'scaleY(1)';
            this.style.boxShadow = 'none';
            
            // Reset stat item
            item.style.transform = 'translateX(0) scale(1)';
            item.style.boxShadow = 'none';
        });
        
        // Animate bar on load
        setTimeout(() => {
            bar.style.height = '0%';
            bar.style.transition = 'height 1s cubic-bezier(0.4, 0, 0.2, 1)';
            setTimeout(() => {
                bar.style.height = `${percentage}%`;
            }, 50);
        }, index * 150);
    });
}

/**
 * Initialize progress bars with animation
 */
function initializeProgressBars() {
    const progressBars = document.querySelectorAll('.stat-progress-bar');
    
    progressBars.forEach((bar, index) => {
        const width = bar.dataset.width;
        bar.style.width = '0%';
        
        setTimeout(() => {
            bar.style.transition = 'width 1.5s cubic-bezier(0.4, 0, 0.2, 1)';
            bar.style.width = width;
        }, index * 100 + 500);
    });
}

/**
 * Initialize hover effects
 */
function initializeHoverEffects() {
    const statItems = document.querySelectorAll('.stat-item');
    
    statItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(8px)';
            this.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.1)';
            
            // Animate progress bar
            const progressBar = this.querySelector('.stat-progress-bar');
            if (progressBar) {
                progressBar.style.transform = 'scaleY(1.1)';
            }
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
            this.style.boxShadow = 'none';
            
            // Reset progress bar
            const progressBar = this.querySelector('.stat-progress-bar');
            if (progressBar) {
                progressBar.style.transform = 'scaleY(1)';
            }
        });
    });
}

/**
 * Toggle between chart and list view
 */
function toggleChartView() {
    const chartContainer = document.getElementById('chartContainer');
    const statisticsList = document.getElementById('statisticsList');
    const toggleIcon = document.getElementById('chartToggleIcon');
    
    if (!chartContainer || !statisticsList || !toggleIcon) return;
    
    const isChartVisible = chartContainer.style.display !== 'none';
    
    if (isChartVisible) {
        // Show list view
        chartContainer.style.display = 'none';
        statisticsList.style.display = 'block';
        toggleIcon.className = 'bi bi-list-ul';
        
        // Animate list items
        const statItems = statisticsList.querySelectorAll('.stat-item');
        statItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            setTimeout(() => {
                item.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, index * 50);
        });
    } else {
        // Show chart view
        chartContainer.style.display = 'block';
        statisticsList.style.display = 'none';
        toggleIcon.className = 'bi bi-bar-chart';
        
        // Reinitialize chart
        setTimeout(() => {
            initializeChartVisualization();
        }, 100);
    }
}

/**
 * Add tooltip functionality
 */
function addTooltips() {
    const statItems = document.querySelectorAll('.stat-item');
    
    statItems.forEach(item => {
        const title = item.querySelector('.stat-item-title').textContent;
        const percentage = item.querySelector('.stat-percentage').textContent;
        const value = item.querySelector('.badge').textContent;
        
        item.setAttribute('title', `${title}: ${value} anggota (${percentage})`);
    });
}

/**
 * Initialize responsive behavior
 */
function initializeResponsive() {
    const handleResize = () => {
        const chartContainer = document.getElementById('chartContainer');
        const statisticsList = document.getElementById('statisticsList');
        
        if (window.innerWidth < 768) {
            // On mobile, default to list view
            if (chartContainer && statisticsList) {
                chartContainer.style.display = 'none';
                statisticsList.style.display = 'block';
            }
        }
    };
    
    window.addEventListener('resize', handleResize);
    handleResize(); // Initial call
}

/**
 * Add keyboard navigation
 */
function initializeKeyboardNavigation() {
    const statItems = document.querySelectorAll('.stat-item');
    
    statItems.forEach((item, index) => {
        item.setAttribute('tabindex', '0');
        item.setAttribute('role', 'button');
        item.setAttribute('aria-label', `Statistik cabang ${index + 1}`);
        
        item.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
}

/**
 * Performance optimization
 */
function optimizePerformance() {
    // Use Intersection Observer for animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, {
        threshold: 0.1
    });
    
    const statItems = document.querySelectorAll('.stat-item');
    statItems.forEach(item => observer.observe(item));
}

// Initialize all features
document.addEventListener('DOMContentLoaded', function() {
    addTooltips();
    initializeResponsive();
    initializeKeyboardNavigation();
    optimizePerformance();
});

// Export functions for global access
window.toggleChartView = toggleChartView;
