package main

import (
	"fmt"
	"io/ioutil"
	"regexp"
	"strconv"
	"strings"
)

func valuesIsGreaterThan(values []int, limit int) bool {
	for _, value := range values {
		if value > limit {
			return false
		}
	}
	return true
}

func isValidGame(values map[string][]int) bool {
	limit := map[string]int{"red": 12, "green": 13, "blue": 14}

	red := valuesIsGreaterThan(values["red"], limit["red"])
	green := valuesIsGreaterThan(values["green"], limit["green"])
	blue := valuesIsGreaterThan(values["blue"], limit["blue"])

	return red && green && blue
}

func main() {
	input, err := ioutil.ReadFile("./data.txt")
	if err != nil {
		panic(err)
	}

	rows := strings.Split(string(input), "\n")
	results := make([]int, 0)

	for _, row := range rows {
		parts := strings.Split(row, ": ")
		name := strings.ReplaceAll(parts[0], "Game ", "")
		valuesAsText := parts[1]

		matches := regexp.MustCompile(`(\d+)\s*([a-zA-Z]+)`).FindAllStringSubmatch(valuesAsText, -1)

		gameData := make(map[string][]int)
		for _, match := range matches {
			count, _ := strconv.Atoi(match[1])
			color := strings.ToLower(match[2])

			if _, ok := gameData[color]; ok {
				gameData[color] = append(gameData[color], count)
			} else {
				gameData[color] = []int{count}
			}
		}

		if isValidGame(gameData) {
			nameInt, _ := strconv.Atoi(name)
			results = append(results, nameInt)
		}
	}

	sum := 0
	for _, result := range results {
		sum += result
	}

	fmt.Println(sum)
}
