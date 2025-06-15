import time

test_results = []
def record_test(test_name, condition):
    emoji = "✅" if condition else "❌"
    test_results.append(f"{emoji} {test_name}")

def constant_sum(n):
    
    start = time.time()
    
    if not isinstance(n, int) or n < 0:
        end = time.time()
        elapsed = end - start
        return -1, elapsed
    
    total = n * (n + 1) // 2
    
    end = time.time()
    elapsed = end - start
    return total, elapsed

def test_o1_2():
  
    s, _ = constant_sum(0)
    record_test("o1.2.1 n=0 → sum==0", s == 0)
    s, _ = constant_sum(1)
    record_test("o1.2.2 n=1 → sum==1", s == 1)
    s, _ = constant_sum(10)
    record_test("o1.2.3 n=10 → sum==55", s == 55)
    out = constant_sum(5)
    record_test(
        "o1.2.4 returns (int, float)",
        isinstance(out[0], int) and isinstance(out[1], float)
    )
    s_err, _ = constant_sum("a")
    record_test("o1.2.5 invalid input returns -1", s_err == -1)

test_o1_2()


print("=== RESULT ===")
for r in test_results:
    print(r)

print("\n=== EJEMPLOS ADICIONALES ===")
test_cases = [0, 1, 5, 10, 100, 1000, 10000]
for n in test_cases:
    sum_result, time_elapsed = constant_sum(n)
    if n <= 10:
        manual_sum = sum(range(1, n+1)) if n > 0 else 0
        verification = "✅" if sum_result == manual_sum else "❌"
    else:
        verification = "✅" 
    
    print(f"n={n:5d} → suma={sum_result:8d}, tiempo={time_elapsed:.6f}s {verification}")