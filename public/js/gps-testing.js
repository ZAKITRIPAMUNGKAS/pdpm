/**
 * GPS TESTING AUTOMATION SCRIPT
 * PDPM Karanganyar - Sistem Absensi GPS
 * 
 * Script ini untuk testing otomatis fungsi GPS dan validasi
 */

class GPSTestingSuite {
    constructor() {
        this.testResults = [];
        this.testCount = 0;
        this.passedTests = 0;
        this.failedTests = 0;
    }

    /**
     * Haversine formula untuk menghitung jarak antara dua koordinat
     */
    calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371000; // Radius bumi dalam meter
        const φ1 = lat1 * Math.PI / 180;
        const φ2 = lat2 * Math.PI / 180;
        const Δφ = (lat2 - lat1) * Math.PI / 180;
        const Δλ = (lon2 - lon1) * Math.PI / 180;

        const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                Math.cos(φ1) * Math.cos(φ2) *
                Math.sin(Δλ/2) * Math.sin(Δλ/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

        return R * c; // Jarak dalam meter
    }

    /**
     * Validasi apakah koordinat dalam radius yang diizinkan
     */
    isWithinRadius(userLat, userLon, eventLat, eventLon, radiusMeters) {
        const distance = this.calculateDistance(userLat, userLon, eventLat, eventLon);
        return {
            valid: distance <= radiusMeters,
            distance: Math.round(distance),
            message: distance <= radiusMeters 
                ? `Lokasi valid. Jarak: ${Math.round(distance)}m dari lokasi kegiatan.`
                : `Lokasi terlalu jauh. Jarak: ${Math.round(distance)}m. Maksimal: ${radiusMeters}m.`
        };
    }

    /**
     * Test case individual
     */
    runTest(testName, testFunction) {
        this.testCount++;
        console.log(`🧪 Running Test ${this.testCount}: ${testName}`);
        
        try {
            const result = testFunction();
            if (result) {
                this.passedTests++;
                console.log(`✅ PASSED: ${testName}`);
                this.testResults.push({
                    name: testName,
                    status: 'PASSED',
                    message: 'Test completed successfully'
                });
            } else {
                this.failedTests++;
                console.log(`❌ FAILED: ${testName}`);
                this.testResults.push({
                    name: testName,
                    status: 'FAILED',
                    message: 'Test assertion failed'
                });
            }
        } catch (error) {
            this.failedTests++;
            console.log(`❌ ERROR: ${testName} - ${error.message}`);
            this.testResults.push({
                name: testName,
                status: 'ERROR',
                message: error.message
            });
        }
    }

    /**
     * Test Suite: GPS Distance Calculation
     */
    testGPSDistanceCalculation() {
        console.log('\n📍 Testing GPS Distance Calculation...\n');

        // Test 1: Same location (should be 0 meters)
        this.runTest('Same Location Distance', () => {
            const distance = this.calculateDistance(-7.6145, 110.9458, -7.6145, 110.9458);
            return Math.abs(distance) < 1; // Allow 1m tolerance
        });

        // Test 2: Known distance (approximately 100m)
        this.runTest('Known Distance Calculation', () => {
            const distance = this.calculateDistance(-7.6145, 110.9458, -7.6154, 110.9468);
            return distance > 90 && distance < 150; // Allow tolerance
        });

        // Test 3: Large distance (should be > 1000m)
        this.runTest('Large Distance Calculation', () => {
            const distance = this.calculateDistance(-7.6145, 110.9458, -7.6245, 110.9558);
            return distance > 1000;
        });
    }

    /**
     * Test Suite: GPS Validation Logic
     */
    testGPSValidation() {
        console.log('\n🎯 Testing GPS Validation Logic...\n');

        // Test coordinates for Karanganyar events
        const eventCoords = {
            kantor: { lat: -7.6145, lon: 110.9458, radius: 50 },
            aula: { lat: -7.6150, lon: 110.9460, radius: 75 },
            masjid: { lat: -7.6140, lon: 110.9455, radius: 100 }
        };

        // Test 1: Valid location within radius
        this.runTest('Valid Location - Kantor PDPM', () => {
            const result = this.isWithinRadius(
                -7.6145, 110.9458, // User at exact location
                eventCoords.kantor.lat, eventCoords.kantor.lon,
                eventCoords.kantor.radius
            );
            return result.valid && result.distance <= 50;
        });

        // Test 2: Valid location near boundary
        this.runTest('Valid Location - Near Boundary', () => {
            const result = this.isWithinRadius(
                -7.6149, 110.9462, // User near aula
                eventCoords.aula.lat, eventCoords.aula.lon,
                eventCoords.aula.radius
            );
            return result.valid;
        });

        // Test 3: Invalid location outside radius
        this.runTest('Invalid Location - Outside Radius', () => {
            const result = this.isWithinRadius(
                -7.6200, 110.9500, // User far away
                eventCoords.kantor.lat, eventCoords.kantor.lon,
                eventCoords.kantor.radius
            );
            return !result.valid && result.distance > 50;
        });

        // Test 4: Edge case - exactly at radius boundary
        this.runTest('Edge Case - Radius Boundary', () => {
            // Calculate coordinates exactly 100m away from masjid
            const result = this.isWithinRadius(
                -7.6149, 110.9455, // Approximately 100m from masjid
                eventCoords.masjid.lat, eventCoords.masjid.lon,
                eventCoords.masjid.radius
            );
            return result.distance <= 100; // Should be valid or very close
        });
    }

    /**
     * Test Suite: Input Validation
     */
    testInputValidation() {
        console.log('\n🔍 Testing Input Validation...\n');

        // Test 1: Invalid coordinates (null/undefined)
        this.runTest('Invalid Coordinates - Null', () => {
            try {
                this.calculateDistance(null, null, -7.6145, 110.9458);
                return false; // Should throw error
            } catch (error) {
                return true; // Expected to fail
            }
        });

        // Test 2: Invalid coordinates (out of range)
        this.runTest('Invalid Coordinates - Out of Range', () => {
            const distance = this.calculateDistance(200, 200, -7.6145, 110.9458);
            return !isNaN(distance); // Should still calculate but be very large
        });

        // Test 3: Zero radius
        this.runTest('Zero Radius Validation', () => {
            const result = this.isWithinRadius(
                -7.6145, 110.9458,
                -7.6145, 110.9458,
                0
            );
            return result.valid; // Same location should be valid even with 0 radius
        });

        // Test 4: Negative radius
        this.runTest('Negative Radius Validation', () => {
            const result = this.isWithinRadius(
                -7.6145, 110.9458,
                -7.6145, 110.9458,
                -50
            );
            return !result.valid; // Should be invalid with negative radius
        });
    }

    /**
     * Test Suite: Performance Testing
     */
    testPerformance() {
        console.log('\n⚡ Testing Performance...\n');

        // Test 1: Single calculation performance
        this.runTest('Single Calculation Performance', () => {
            const startTime = performance.now();
            this.calculateDistance(-7.6145, 110.9458, -7.6150, 110.9460);
            const endTime = performance.now();
            const duration = endTime - startTime;
            console.log(`   Single calculation took: ${duration.toFixed(2)}ms`);
            return duration < 10; // Should be under 10ms
        });

        // Test 2: Bulk calculation performance
        this.runTest('Bulk Calculation Performance', () => {
            const startTime = performance.now();
            for (let i = 0; i < 1000; i++) {
                this.calculateDistance(
                    -7.6145 + (Math.random() * 0.01),
                    110.9458 + (Math.random() * 0.01),
                    -7.6150, 110.9460
                );
            }
            const endTime = performance.now();
            const duration = endTime - startTime;
            console.log(`   1000 calculations took: ${duration.toFixed(2)}ms`);
            return duration < 100; // Should be under 100ms for 1000 calculations
        });
    }

    /**
     * Test Suite: Real-world Scenarios
     */
    testRealWorldScenarios() {
        console.log('\n🌍 Testing Real-world Scenarios...\n');

        // Scenario 1: Member arrives early at exact location
        this.runTest('Scenario: Early Arrival - Exact Location', () => {
            const result = this.isWithinRadius(
                -7.6145, 110.9458, // Exact kantor location
                -7.6145, 110.9458,
                50
            );
            return result.valid && result.distance < 5;
        });

        // Scenario 2: Member arrives at parking area (within radius)
        this.runTest('Scenario: Parking Area - Within Radius', () => {
            const result = this.isWithinRadius(
                -7.6147, 110.9460, // Nearby parking
                -7.6145, 110.9458,
                50
            );
            return result.valid && result.distance <= 50;
        });

        // Scenario 3: Member tries to cheat from home
        this.runTest('Scenario: Cheating Attempt - From Home', () => {
            const result = this.isWithinRadius(
                -7.6200, 110.9500, // Far from event
                -7.6145, 110.9458,
                50
            );
            return !result.valid && result.distance > 100;
        });

        // Scenario 4: GPS accuracy issues (slight variation)
        this.runTest('Scenario: GPS Accuracy Variation', () => {
            const variations = [
                { lat: -7.6145001, lon: 110.9458001 },
                { lat: -7.6144999, lon: 110.9457999 },
                { lat: -7.6145002, lon: 110.9458002 }
            ];
            
            let allValid = true;
            variations.forEach(coord => {
                const result = this.isWithinRadius(
                    coord.lat, coord.lon,
                    -7.6145, 110.9458,
                    50
                );
                if (!result.valid) allValid = false;
            });
            
            return allValid; // All slight variations should be valid
        });
    }

    /**
     * Mock AJAX test for server integration
     */
    async testServerIntegration() {
        console.log('\n🔗 Testing Server Integration...\n');

        // Test 1: Valid absensi submission (mock)
        this.runTest('Mock Server - Valid Submission', () => {
            const mockData = {
                id_agenda: 1,
                latitude: -7.6145,
                longitude: 110.9458
            };
            
            // Simulate validation that would happen on server
            const result = this.isWithinRadius(
                mockData.latitude, mockData.longitude,
                -7.6145, 110.9458, // Event location
                50 // Radius
            );
            
            return result.valid;
        });

        // Test 2: Invalid absensi submission (mock)
        this.runTest('Mock Server - Invalid Submission', () => {
            const mockData = {
                id_agenda: 1,
                latitude: -7.6200,
                longitude: 110.9500
            };
            
            const result = this.isWithinRadius(
                mockData.latitude, mockData.longitude,
                -7.6145, 110.9458,
                50
            );
            
            return !result.valid;
        });
    }

    /**
     * Run all test suites
     */
    async runAllTests() {
        console.log('🚀 Starting GPS Testing Suite for PDPM Karanganyar\n');
        console.log('=' .repeat(60));

        // Reset counters
        this.testResults = [];
        this.testCount = 0;
        this.passedTests = 0;
        this.failedTests = 0;

        // Run all test suites
        this.testGPSDistanceCalculation();
        this.testGPSValidation();
        this.testInputValidation();
        this.testPerformance();
        this.testRealWorldScenarios();
        await this.testServerIntegration();

        // Display results
        this.displayResults();
    }

    /**
     * Display test results summary
     */
    displayResults() {
        console.log('\n' + '=' .repeat(60));
        console.log('📊 TEST RESULTS SUMMARY');
        console.log('=' .repeat(60));
        
        console.log(`Total Tests: ${this.testCount}`);
        console.log(`✅ Passed: ${this.passedTests}`);
        console.log(`❌ Failed: ${this.failedTests}`);
        console.log(`Success Rate: ${((this.passedTests / this.testCount) * 100).toFixed(1)}%`);

        if (this.failedTests > 0) {
            console.log('\n❌ FAILED TESTS:');
            this.testResults
                .filter(test => test.status !== 'PASSED')
                .forEach(test => {
                    console.log(`   - ${test.name}: ${test.message}`);
                });
        }

        console.log('\n🎯 TESTING COMPLETE!');
        
        if (this.failedTests === 0) {
            console.log('🎉 All tests passed! GPS system is ready for production.');
        } else {
            console.log('⚠️  Some tests failed. Please review and fix issues before deployment.');
        }

        // Return results for programmatic use
        return {
            total: this.testCount,
            passed: this.passedTests,
            failed: this.failedTests,
            successRate: (this.passedTests / this.testCount) * 100,
            results: this.testResults
        };
    }

    /**
     * Generate HTML report
     */
    generateHTMLReport() {
        const html = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>GPS Testing Report - PDPM Karanganyar</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { background: #2c3e50; color: white; padding: 20px; border-radius: 5px; }
                .summary { background: #ecf0f1; padding: 15px; margin: 20px 0; border-radius: 5px; }
                .test-result { margin: 10px 0; padding: 10px; border-radius: 3px; }
                .passed { background: #d5f4e6; border-left: 4px solid #27ae60; }
                .failed { background: #fadbd8; border-left: 4px solid #e74c3c; }
                .error { background: #fdeaa7; border-left: 4px solid #f39c12; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>GPS Testing Report</h1>
                <p>PDPM Karanganyar - Sistem Absensi GPS</p>
                <p>Generated: ${new Date().toLocaleString()}</p>
            </div>
            
            <div class="summary">
                <h2>Summary</h2>
                <p><strong>Total Tests:</strong> ${this.testCount}</p>
                <p><strong>Passed:</strong> ${this.passedTests}</p>
                <p><strong>Failed:</strong> ${this.failedTests}</p>
                <p><strong>Success Rate:</strong> ${((this.passedTests / this.testCount) * 100).toFixed(1)}%</p>
            </div>
            
            <div class="results">
                <h2>Detailed Results</h2>
                ${this.testResults.map(test => `
                    <div class="test-result ${test.status.toLowerCase()}">
                        <strong>${test.name}</strong><br>
                        Status: ${test.status}<br>
                        Message: ${test.message}
                    </div>
                `).join('')}
            </div>
        </body>
        </html>
        `;
        
        return html;
    }
}

// Auto-run tests when script is loaded
if (typeof window !== 'undefined') {
    // Browser environment
    window.GPSTestingSuite = GPSTestingSuite;
    
    // Add button to run tests
    document.addEventListener('DOMContentLoaded', function() {
        const button = document.createElement('button');
        button.textContent = 'Run GPS Tests';
        button.style.cssText = 'position:fixed;top:10px;right:10px;z-index:9999;padding:10px;background:#3498db;color:white;border:none;border-radius:5px;cursor:pointer;';
        button.onclick = async function() {
            const suite = new GPSTestingSuite();
            const results = await suite.runAllTests();
            
            // Show results in modal or new window
            const reportWindow = window.open('', '_blank');
            reportWindow.document.write(suite.generateHTMLReport());
        };
        document.body.appendChild(button);
    });
} else {
    // Node.js environment
    module.exports = GPSTestingSuite;
}

// Example usage:
// const suite = new GPSTestingSuite();
// suite.runAllTests();
